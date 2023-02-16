    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>{{ config('app.name', 'ArgostudioADV') }}</title>

        <!-- Scripts -->
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{-- {{ config('app.name', 'ArgostudioADV') }} --}}ArgostudioADV
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.messages.index', Auth::user()->id) }}">
                                            {{ __('Messaggi') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('get.messages') !!}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'text',
                        name: 'text'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'note',
                        name: 'note'
                    },
                    {
                        data: 'tipes',
                        name: 'tipes'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'active',
                        name: 'active'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            //TOKEN
            function token() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            //REFRESH TABELLA
            function refresh() {
                var table = $('#myTable').DataTable();
                table.ajax.reload(null, false);
                console.log('refresh success');
            }
            //PULIZIA CAMPI TABELLA
            function cleaner() {
                $('#postForm')[0].reset();
                $("#postForm .invalid-feedback").empty();
                $('#text').removeClass('is-invalid');
                $('#note').removeClass('is-invalid');
                $('#active').removeClass('is-invalid');
                $('#start_time').removeClass('is-invalid');
                $('#end_time').removeClass('is-invalid');
                $('#tipes').removeClass('is-invalid');
                $('#url').removeClass('is-invalid');
                console.log('cleaner success');
            }

            //SHOWUP DEL MODAL AL BOTTONE DI CREA MESSAGGIO
            $('#createNewMessage').click(function() {
                $('#savedata').val("create-message");
                $('#id').val('');
                $('#messageForm').trigger("reset");
                $('#modelHeading').html("Create New Message");
                $('#modalStore').modal('show');
            });

            //STORE DEL MESSAGGIO
            $(document).on('submit', '#postForm', function(e) {
                e.preventDefault();
                @if (Auth::check())
                    var messageForm = $("form#postForm").serializeArray();
                    token();
                    var data = {
                        text: messageForm[0].value,
                        url: messageForm[1].value,
                        note: messageForm[2].value,
                        tipes: messageForm[3].value,
                        start_time: messageForm[4].value,
                        end_time: messageForm[5].value,
                        active: messageForm[6].value,
                    };
                    console.log(data);
                    $.ajax({
                        url: "{{ route('admin.messages.store', ['user' => auth()->user()->id]) }}",
                        method: 'POST',
                        data: data,
                        success: function(result) {
                            console.log(result)
                            refresh();
                            $('#modalStore').modal('hide');

                            $('#message-success').text(result.success);

                            $('#message-success').show();
                            cleaner()
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            // Mostra gli errori di validazione nel form del modale
                            var errors = data.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('input[name=' + key + ']').addClass('is-invalid');
                                $('input[name=' + key + ']').closest('.form-group')
                                    .append(
                                        '<span class="invalid-feedback" role="alert"><strong>' +
                                        value[0] + '</strong></span>');
                            });
                        }
                    });
                @endif
            });

            //EDIT DEL MESSAGGIO
            $(document).on('click', '.editButton', function(e) {
                e.preventDefault();
                @if (Auth::check())
                    var id = $(this).data("id");
                    var auth = {{ auth()->user()->id }};
                    /* var editRoute = "/admin/user/" + {{ auth()->user()->id }} + "/messages"; */
                    console.log('auth id ' + auth);
                    console.log('message id  ' + id);
                    token();
                    $.ajax({
                        /* url: "{{ route('admin.messages.edit', ['user' => auth()->user()->id, 'message' => ':id']) }}".replace(':id', id), */
                        /* url: editRoute + "/" + id, */
                        url: '/admin/user/' + auth + '/messages/' + id,
                        type: "GET",
                        /* dataType: 'json', */

                        success: function(result) {
                            /* let json = jQuery.parseJSON(result.data); */
                            console.log(result);
                            var message = result.data;
                            console.log(message);
                            console.log('URL of the request:', this.url);
                            $('.id').val(message.id);
                            $('.text').val(message.text);
                            $('.tipes').val(message.tipes);
                            $('.url').val(message.url);
                            $('.note').val(message.note);
                            $('.start_time').val(message.start_time);
                            $('.end_time').val(message.end_time);
                            $('.active').val(message.active);
                            $('#modalEdit').modal('show');
                            $('.modal-title').text('Update Message');

                        },
                        error: function(xhr, status, error) {
                            console.log("error" + xhr.responseText);
                            console.log(xhr);
                            console.log(status);
                            console.log(error);

                        }
                    });
                @endif
            });

            //UPDATE DEL MESSAGGIO
            $(document).on('submit', '#modalEdit', function(e) {
                @if (Auth::check())
                    var formData = $("form#update").serializeArray();
                    console.log(formData)
                    token();

                    var id = formData[0].value
                    var data = {
                        text: formData[1].value,
                        url: formData[2].value,
                        note: formData[3].value,
                        tipes: formData[4].value,
                        start_time: formData[5].value,
                        end_time: formData[6].value,
                        active: formData[7].value,
                    };
                    console.log("value data " + data)
                    console.log(id)
                    $.ajax({
                        url: "{{ route('admin.messages.update', ['user' => auth()->user()->id, 'message' => ':id']) }}"
                            .replace(':id', id),
                        method: 'PUT',
                        data: data,
                        success: function(result) {
                            if (result.success) {
                                refresh();
                                cleaner();
                                $('#modalEdit').modal('hide');
                                console.log('success update');
                            } else {
                                console.log('failed');
                            }
                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            refresh();
                            console.log(response)
                            console.log(status)
                            console.log(error)
                        }
                    });
                @endif
            });


            //DELETE DEL MESSAGGIO
            $('body').on('click', '.deleteMessage', function(e) {
                e.preventDefault();
                token();

                @if (Auth::check())
                    {
                        var destroyRoute =
                            "{{ url('admin/user/' . auth()->user()->id . '/messages') }}";
                        var id = $(this).data("id");
                        console.log(id);

                        // Dialogo di conferma
                        var result = confirm("Are you sure you want to delete this message?");
                        if (result) {
                            // inviamo la richiesta delete
                            $.ajax({
                                method: 'POST',
                                url: destroyRoute + "/" + id,
                                data: {
                                    id: id,
                                    // set a parameter named _method with value 'delete'
                                    _method: 'delete',
                                },
                                success: function(data) {
                                    console.log("eliminato");
                                    $('#message-success-delete').show();
                                    refresh();
                                },
                                error: function(data) {
                                    console.log("errore")
                                    console.log('Error:', data);
                                }
                            });
                        }
                    }
                @endif
            });
        });
    </script>

    </html>
