<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('vendor/devtools/bootstrap/css/bootstrap.min.css') }}">

    <style>
        table {
            font-size: .9rem;
        }
    </style>

    <title>Devtools</title>
</head>
<body>

    <main>
        @if(session(\AlirezaH\LaravelDevTools\Http\Middleware\AuthDevTools::AUTHENTICATED_SESSION_KEY))
            @include('devtools::partials.navbar')
        @endif

        <div class="container">
            <div class="pt-md-5">
                @if($errors->count())
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <h5 class="mb-3">
                            <i class="fa fa-warning"></i> {{ __('Error') }}
                        </h5>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert alert-info">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <h5 class="mb-2">
                            <i class="fa fa-warning"></i> {{ __('Message') }}
                        </h5>
                        <br>
                        {{ session('message') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    <script src="{{ asset('vendor/devtools/bootstrap/js/jquery-3.4.1.slim.min.js') }}"></script>
    <script src="{{ asset('vendor/devtools/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/devtools/bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>
