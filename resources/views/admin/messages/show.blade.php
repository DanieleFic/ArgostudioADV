@extends('layouts.app')


@section('title', 'Vista Messaggio')


@section('content')


    <div class="container message py-5">
        <button type="button" class="btn-secondary m-2"><a
                href="{{ route('admin.messages.index', [Auth::user()->id]) }}">Torna alla lista dei messaggi</a></button>

        <div class="{{ $message->active ? 'ms_cardmessage_active' : 'ms_cardmessage_notactive' }} mb-2">
            <div class="ms_info  p-3 d-flex align-items-center justify-content-between">
                <div>
                    <p></p>
                    <h3 class="m-0">Tipo di messaggio :{{ $message->tipes }}</h3>
                </div>
                <div class="d-flex">
                    <div class="p-2">
                        <i class="fa-solid fa-calendar-week p-2"></i>
                        <p class="m-0">data inizio:</p>
                        <p class="mb-2">{{ $startDate }}</p>
                    </div>
                    <div class="p-2">
                        <i class="fa-solid fa-calendar-week p-2"></i>
                        <p class="m-0">data fine:</p>
                        <p>{{ $endDate }}</p>
                    </div>
                </div>
            </div>

            <div class="ms_text p-4">
                <h3>url del messaggio</h3>
                {{ $message->url }}
            </div>

            <div class="ms_text p-4">
                <h3>testo</h3>
                {{ $message->text }}
            </div>
            <div class="ms_text p-4">
                <h3>nota</h3>
                {{ $message->note }}
            </div>

            <div class="ms_buttonbox d-flex ">

                <a href="{{ route('admin.messages.edit', [Auth::user()->id, $message->id]) }}"><button type="button"
                        class="btn-secondary border-0  rounded-left btn_edit"><i
                            class="fa-solid fa-pen-to-square"></i></button></a>

                <button type="button" class="btn-secondary border-0  rounded-right w-50" data-toggle="modal"
                    data-target="#exampleModal">
                    <i class="fa-solid fa-trash-can"></i>
                </button>

            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cancella</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Sicuro di voler cancellare questo messaggio? {{ $message->id }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Indietro</button>
                        <form action="{{ route('admin.messages.destroy', [Auth::user()->id, $message->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn ms_buttonblue text-white" data-toggle="modal"
                                data-target="#exampleModal">
                                Cancella
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>







    </div>

@endsection
