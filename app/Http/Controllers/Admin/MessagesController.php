<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

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
        $activeMessages = Message::where('user_id', Auth::user()->id)
            ->where('active', true)
            ->orderBy('created_at', 'DESC')
            ->get();

        $notActiveMessages = Message::where('user_id', Auth::user()->id)
            ->where('active', false)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.messages.index', compact('user', 'activeMessages', 'notActiveMessages','startDate','endDate'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Message $message)
    {
        $user = Auth::user();

        $dateTime = new DateTime($message->start_time);
        $startDate = $dateTime->format('d/m/Y');

        $dateTime = new DateTime($message->end_time);
        $endDate = $dateTime->format('d/m/Y');


        return view('admin.messages.show', compact('user', 'message','startDate','endDate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
{
    $message = Message::findOrFail($id);
    /* @dd($message); */
    return view('admin.messages.edit', compact('user', 'message'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user, $id)
    {
        /* @dd($id); */
        try {
            $message = Message::findOrFail($id);

            $request->validate($this->validation);

            $form_data = $request->all();
            /* @var_dump($form_data); */
            $message->update($form_data);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Messaggio non trovato.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Codice prodotto esistente.')->with('success', 'Messaggio modificato');
            }
        }
        return redirect()->route('admin.messages.show', [$user->id, $message->id]);

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
