<nav class="navbar navbar-expand-lg sticky-top {{ config('app.env') == 'production' ? 'navbar-dark bg-danger' : 'navbar-dark bg-info' }}">
    <a class="navbar-brand" href="{{ route('devtools.index') }}">Dev Tools <small style="font-size: 12px;">({{ ucfirst(config('app.env')) }} ,Laravel {{ app()->version() }})</small></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('devtools.index') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.password') }}">Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.tools') }}">Tools</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarErrorDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Errors
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarErrorDropdown">
                    <a class="dropdown-item" href="{{ route('devtools.errors', ['type' => 'error']) }}">Error</a>
                    @foreach(config('devtools.error_logger.types') as $type => $config)
                        <a class="dropdown-item" href="{{ route('devtools.errors', ['type' => $type]) }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.commands') }}">Commands</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.schema.tables') }}">Schema</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.cache.index') }}">Cache</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.mails.index') }}">Mails</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('devtools.packages.index') }}">Packages</a>
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
