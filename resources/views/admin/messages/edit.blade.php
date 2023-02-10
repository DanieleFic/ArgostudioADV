@extends('layouts.app')

@section('title', 'Modifica Messaggio')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>MODIFICA Messaggio {{ $message->id }}</h1>
            </div>
            <div class="col-6">
                <a href="{{ route('admin.messages.index', [Auth::user()->id, $message->id]) }}"><button type="button"
                        class="btn btn-info">Indietro</button></a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.messages.update', [Auth::user()->id, $message->id]) }}" method="POST"
                    role="form">
                    @csrf
                    @method('PUT')


                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Tipo del messaggio</label>
                        <select name="tipes">
                            <option value="A" {{ $message->types == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $message->types == 'B' ? 'selected' : '' }}>B</option>
                        </select>
                        @error('tipes')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Attivo</label>
                        <select name="active">
                            <option value="1" {{ $message->active == '1' ? 'selected' : '' }}>Si</option>
                            <option value="0" {{ $message->active == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('active')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">

                        <div class="form-group">
                            <label for="start_time">Data inizio:</label>
                            <input type="date" class="form-control" name="start_time" value="{{ $message->start_time }}">
                        </div>

                        @error('start_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">

                        <div class="form-group">
                            <label for="end_time">Data fine:</label>
                            <input type="date" class="form-control" name="end_time" value="{{ $message->end_time }}">
                        </div>

                        @error('end_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Url messaggio</label>
                        <input name="url" value="{{ $message->url }}" type="text" class="form-control"
                            id="url" placeholder="Inserici nome">
                        @error('url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Modifica testo</label>
                        <textarea type="text-area" name="text" value="{{ $message->text }}"
                            class="form-control @error('text') is-invalid @enderror" placeholder="Inserisci testo messaggio">{{ $message->text }}</textarea>
                        @error('text')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Modifica nota</label>
                        <textarea type="text-area" name="note" value="{{ $message->note }}"
                            class="form-control @error('note') is-invalid @enderror" placeholder="Inserisci nota messaggio">{{ $message->text }}</textarea>
                        @error('note')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" name="Submit" value="Publish"
                            class="ms_button btn btn-primary form-control" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
