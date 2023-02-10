@extends('layouts.app')


@section('title', 'Elenco messaggi')


@section('content')

    <div class="container py-5">
        {{--     @dd($messages) --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (count($activeMessages) || count($notActiveMessages) > 0)
            {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@ MESSAGGI ATTIVI @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}
            <div class="row justify-content-center">

                <div class="col-12">

                    <div class="d-flex justify-content-between align-items-center">
                        <h1>
                            Hai
                            ({{ count($activeMessages) }})
                            @if (count($activeMessages) >= 1)
                                messaggio attivo
                            @else
                                messaggi attivi
                            @endif
                        </h1>
                    </div>
                </div>

                <div class='col-12'>
                    @if (count($activeMessages) > 0)

                        @foreach ($activeMessages as $message)
                            <div class="ms_cardmessage_active  my-4">
                                <div class="ms_info  p-3 d-flex align-items-center justify-content-between">
                                    <div>
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

                                    <a href="{{ route('admin.messages.show', [Auth::user()->id, $message->id]) }}">
                                        <button type="button" class="ms_buttonblue text-white rounded-left">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.messages.edit', [Auth::user()->id, $message->id]) }}"><button
                                            type="button" class="btn-secondary border-0  rounded-left btn_edit"><i
                                                class="fa-solid fa-pen-to-square"></i></button></a>

                                    <button type="button" class="btn-secondary border-0  rounded-right w-50"
                                        data-toggle="modal" data-target="#exampleModal{{ $message->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Indietro</button>
                                            <form
                                                action="{{ route('admin.messages.destroy', [Auth::user()->id, $message->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn ms_buttonblue text-white"
                                                    data-toggle="modal" data-target="#exampleModal">
                                                    Cancella
                                                </button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>Non ci sono messaggi!</div>
                    @endif
                </div>
            </div>
            {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@ MESSAGGI ATTIVI @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1>
                            Hai
                            ({{ count($notActiveMessages) }})
                            @if (count($notActiveMessages) == 1)
                                messaggio non attivo
                            @else
                                messaggi non attivi
                            @endif
                        </h1>
                    </div>
                </div>

                <div class='col-12'>
                    @if (count($notActiveMessages) > 0)
                        @foreach ($notActiveMessages as $message)
                            <div class="ms_cardmessage_notactive  my-4">
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

                                    <a href="{{ route('admin.messages.show', [Auth::user()->id, $message->id]) }}">
                                        <button type="button" class="ms_buttonblue text-white rounded-left">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('admin.messages.edit', [Auth::user()->id, $message->id]) }}"><button
                                            type="button" class="btn-secondary border-0  rounded-left btn_edit"><i
                                                class="fa-solid fa-pen-to-square"></i></button></a>

                                    <button type="button" class="btn-secondary border-0  rounded-right w-50"
                                        data-toggle="modal" data-target="#exampleModal{{ $message->id }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>

                                </div>
                            </div>
                            <!--------------------------------- Modal ------------------------------>
                            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cancella</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Sicuro di voler cancellare questo messaggio?{{ $message->id }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Indietro</button>
                                            <form
                                                action="{{ route('admin.messages.destroy', [Auth::user()->id, $message->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn ms_buttonblue text-white  btn-danger "
                                                    data-toggle="modal" data-target="#exampleModal">
                                                    Cancella
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>Non ci sono messaggi!</div>
                    @endif
                </div>
            @else
                <div>Non ci sono messaggi!</div>
            </div>
    </div>

    @endif

    </div>
@endsection
