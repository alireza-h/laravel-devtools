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

    <title>Dev</title>
</head>
<body>

    <main>
        <nav class="navbar navbar-expand-lg sticky-top {{ config('app.env') == 'production' ? 'navbar-dark bg-danger' : 'navbar-dark bg-info' }}">
            <a class="navbar-brand" href="{{ route('dev.index') }}">Dev Tools <small style="font-size: 12px;">({{ ucfirst(config('app.env')) }} ,Laravel {{ app()->version() }})</small></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('dev.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.password') }}">Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.tools') }}">Tools</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarErrorDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Errors
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarErrorDropdown">
                            <a class="dropdown-item" href="{{ route('dev.errors', ['type' => 'error']) }}">Error</a>
                            @foreach(config('devtools.error_logger.types') as $type => $config)
                                <a class="dropdown-item" href="{{ route('dev.errors', ['type' => $type]) }}">{{ title_case($type) }}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.commands') }}">Commands</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.schema.tables') }}">Schema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.cache.index') }}">Cache</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dev.mails.index') }}">Mails</a>
                    </li>
                    @foreach(config('devtools.custom_menu') as $menuItem)
                        @if($menuItem['active'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($menuItem['url']) }}">{{ $menuItem['title'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div>
                    <span class="text-white">@yield('page', '')</span>
                </div>
            </div>
        </nav>

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
