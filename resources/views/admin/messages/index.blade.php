@extends('layouts.app')


@section('title', 'Elenco messaggi')


@section('content')

    <div class="container py-5">
        <a class="btn btn-info" href="javascript:void(0)" id="createNewMessage"> Add New Message</a>
        {{--     @dd($messages) --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="alert alert-success" id="message-success" style="display:none;"></div>
        <div class="alert alert-success" id="message-success-delete" style="display:none;">Messaggio eliminato</div>
        <table class="table" id="myTable">
            <thead>
                <tr class="text-center">
                    <th scope="col">id</th>
                    <th scope="col">Testo</th>
                    <th scope="col">Url</th>
                    <th scope="col">note</th>
                    <th scope="col">tipo</th>
                    <th scope="col">data inizio</th>
                    <th scope="col">data fine</th>
                    <th scope="col">attivo</th>
                    <th scope="col">Azioni</th>


                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <th scope="row">{{ $message->id }}</th>
                        <td>{{ $message->text }}</td>
                        <td>{{ $message->note }}</td>
                        <td>{{ $message->url }}</td>
                        <td>{{ $message->start_time }}</td>
                        <td>{{ $message->end_time }}</td>
                        <td>{{ $message->active }}</td>
                        <td>{{ $message->tipes }}</td>
                    </tr>
                @endforeach
            </tbody> --}}
        </table>
        {{-- MODAL FOR ADD --}}
        <div class="modal fade" id="modalStore" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Aggiungi nuovo messaggio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="postForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="text">Testo</label>
                                <input type="text-area" class="form-control" id="text" name="text">
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" id="url" name="url">
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" class="form-control" id="note" name="note">
                            </div>
                            <div class="form-group">
                                {{-- <label for="tipes">Tipo</label>
                                <input type="text" class="form-control" id="tipes" name="tipes"> --}}
                                <label for="tipes">Tipo</label>
                                <select name="tipes" id="tipes">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_time">Inizio</label>
                                <input type="date" class="form-control" id="start_time" name="start_time">
                            </div>
                            <div class="form-group">
                                <label for="end_time">Fine</label>
                                <input type="date" class="form-control" id="end_time" name="end_time">
                            </div>
                            <div class="form-group">
                                <label for="active">Attivo</label>
                                {{-- <input type="text" class="form-control" id="active" name="active"> --}}
                                <label for="active">Attivo</label>
                                <select name="active" id="active">
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                <button class="btn btn-primary" type="submit">Salva</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        {{-- MODAL FOR EDIT --}}
        <div id="modalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Header</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="update">
                        <div class="modal-body">
                            <input type="hidden" name="id" class="id">
                            <div class="form-group">
                                <label for="text">Testo</label>
                                <input type="text-area" class="form-control text" id="text" name="text">
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control url" id="url" name="url">
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" class="form-control note" id="note" name="note">
                            </div>
                            <div class="form-group">
                                {{-- <label for="tipes">Tipo</label>
                                <input type="text" class="form-control" id="tipes" name="tipes"> --}}
                                <label for="tipes">Tipo</label>
                                <select name="tipes" id="tipes" class="tipes">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_time">Inizio</label>
                                <input type="date" class="form-control start_time" id="start_time" name="start_time">
                            </div>
                            <div class="form-group">
                                <label for="end_time">Fine</label>
                                <input type="date" class="form-control end_time" id="end_time" name="end_time">
                            </div>
                            <div class="form-group">
                                <label for="active">Attivo</label>
                                {{-- <input type="text" class="form-control" id="active" name="active"> --}}
                                <label for="active">Attivo</label>
                                <select name="active" id="active" class="active">
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="#" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endsection
