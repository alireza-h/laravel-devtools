@extends('devtools::master')

@section('page', 'Commands')

@section('content')
    <div class="mb-5">
        <div class="accordion" id="accordionCommand">

            @foreach($commands as $id => $command)

                <div class="card">
                    <div class="card-header" id="heading--{{ $id }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse--{{ $id }}" aria-expanded="true" aria-controls="collapse--{{ $id }}">
                                {{ $command['name'] }}
                            </button>
                        </h2>
                    </div>

                    <div id="collapse--{{ $id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading--{{ $id }}" data-parent="#accordionCommand">
                        <div class="card-body">
                            <div class="pb-2">
                                <code>{{ $command['name'] }}</code>
                                <samp class="pl-3 text-info">php artisan {{ $command['synopsis'] }}</samp>
                            </div>
                            @if($command['description'])
                                <div class="pb-2 text-muted">
                                    {{ $command['description'] }}
                                </div>
                            @endif

                            @if($command['args'])
                                <div class="pt-5">
                                    <h4>args</h4>
                                    @foreach($command['args'] as $name => $arg)
                                        <div class="pt-2 pb-4">
                                            <code>{{ $name }}</code>
                                            <pre>{{ $arg['description'] }}</pre>
                                            @if($arg['isRequired'])
                                                <small>required</small>
                                            @endif
                                            @if($arg['isArray'])
                                                <small>array</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($command['options'])
                                <div class="pt-5">
                                    <h4>options</h4>
                                    @foreach($command['options'] as $name => $option)
                                        <div class="pt-2 pb-4">
                                            <code>--{{ $name }}</code>
                                            @if($option['shortcut'])
                                                <kbd>{{ $option['shortcut'] ? '-' . $option['shortcut'] : '' }}</kbd>
                                            @endif
                                            @if($option['description'])
                                                <pre>{{ $option['description'] }}</pre>
                                            @endif
                                            @if($option['default'])
                                                <div><span class="text-muted">default: </span> {{ $option['default'] }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-5">
                                <form action="{{ route('devtools.commands.run', ['command' => $command['name']]) }}" method="get" target="_blank">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control"
                                               name="command"
                                               placeholder="php artisan {{ $command['synopsis'] }}"
                                               value="{{ $command['synopsis'] }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning" type="submit">Run</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
@endsection
