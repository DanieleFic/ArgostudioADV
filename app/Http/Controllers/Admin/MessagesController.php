<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Yajra\DataTables\Facades\DataTables;

class MessagesController extends Controller
{

    protected $validation = [
        'text' => 'required|string|between:30,5000',
        "name" => 'in:A,B',
        'url' => 'required|max:500',
        "start_time" => 'required|date|date_format:Y-m-d',
        "end_time" => 'required|date|date_format:Y-m-d',
        'note' => 'required|max:500',
        'active' => 'required|boolean',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Message $message)
    {
        //
        $dateTime = new DateTime($message->start_time);
        $startDate = $dateTime->format('d/m/Y');

        $dateTime = new DateTime($message->end_time);
        $endDate = $dateTime->format('d/m/Y');

        $user = Auth::user();
        $messages = Message::where('user_id', Auth::user()->id)->get();

        return view('admin.messages.index', compact('user', 'messages', 'startDate', 'endDate'));
    }


    public function getMessages()
    {
        $user = Auth::user();
        return DataTables::of(Message::query())
            ->addColumn('action', function ($message) use ($user) {
                return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $message->id . '" id="edit" data-original-title="Edit" class="edit btn btn-primary btn-sm editButton"></i> Modifica</a>
            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteMessage" data-id="' . $message->id . '" data-user="' . auth()->user()->id . '" data-toggle="modal" data-target="#delete-modal-' . $message->id . '"><i class="glyphicon glyphicon-trash"></i> Elimina</a>
            ';
            })
            ->setRowClass('{{$id % 2 == 0 ? "alert-success" : "alert-danger"}}')
            ->setRowId(function ($message) {
                return $message->id;
            })
            ->setRowAttr(['align' => 'center'])

            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation);

        $form_data = $request->all();


        $newMessage = new Message();

        $newMessage->fill($form_data);
        $newMessage->user_id = auth()->user()->id; // Imposta l'id dell'utente autenticato come user_id del messaggio
        /* $newMessage->save(); */
        $newMessage->save();
        return response()->json(['success' => 'Il messaggio è stato salvato correttamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\messages  $messages
     * @return \Illuminate\Http\Response
     */
    /* public function show(User $user, Message $message)
    {
        $user = Auth::user();

        $dateTime = new DateTime($message->start_time);
        $startDate = $dateTime->format('d/m/Y');

        $dateTime = new DateTime($message->end_time);
        $endDate = $dateTime->format('d/m/Y');


        return view('admin.messages.show', compact('user', 'message', 'startDate', 'endDate'));
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId, $id)
    {
        $message = Message::where('id', $id)
            ->where('user_id', $userId)
            ->first();
        /* $jsonMessage = $message->toJson(); */
        if ($message) {
            return response()->json(['success' => 'successfull retrieve data', 'data' => $message], 200);
        } else {
            return response()->json(['error' => 'Message not found'], 404);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Message $message)
    {
        /* try {

            $request->validate($this->validation);
            $form_data = $request->all();
            $message->update($form_data);
            return response()->json(['success' => 'data is successfully updated'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        if ($request->fails()) {
            return back()->withInput()->withErrors($request);
        } */
        try {
            $request->validate($this->validation);
            $form_data = $request->all();
            $message->update($form_data);
            return response()->json(['success' => 'data is successfully updated'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Error updating data. Please try again.']);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  Message dependency injection with passed id of message
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Message $message)
    {

        $message->delete();

        return redirect()->route('admin.messages.index', Auth::id())->with('success', 'Messaggio Cancellato');
    }
}
