@extends('devtools::master')

@section('page', 'Packages')

@section('content')
    <div class="mb-5">
        <div class="accordion" id="accordionCommand">

            @foreach($packages as $index => $package)

                <div class="card">
                    <div class="card-header" id="heading--{{ $index }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse--{{ $index }}" aria-expanded="true" aria-controls="collapse--{{ $index }}">
                                {{ $package['name'] }}
                            </button>
                        </h2>
                    </div>

                    <div id="collapse--{{ $index }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading--{{ $index }}" data-parent="#accordionCommand">
                        <div class="card-body">
                            <div class="pb-2">
                                <samp class="text-info">{{ $package['name'] }}</samp> &nbsp;
                                <kbd>{{ $package['version'] }}</kbd>
                            </div>

                            @if($package['description'])
                                <div class="pb-2 mt-2 mb-4 text-muted">
                                    {{ $package['description'] }}
                                </div>
                            @endif

                            @if(!empty($package['homepage']))
                                <div class="mt-2">
                                    Home Page:
                                    <a href="{{ $package['homepage'] }}" target="_blank">{{ $package['name'] }}</a>
                                </div>
                            @endif

                            @if(!empty($package['keywords']))
                                <div class="mt-2">
                                    Keywords:
                                    @foreach($package['keywords'] as $keyword)
                                        <code>{{ $keyword }}</code>
                                        {{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </div>
                            @endif

                            <div class="pt-5">
                                <h4>Require</h4>
                                <div class="pt-2 pb-4">
                                    <pre>
@json($package['require'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)
                                    </pre>
                                </div>
                            </div>

                            @if(!empty($package['require-dev']))
                                <div class="pt-5">
                                    <h4>Require Dev</h4>
                                    <div class="pt-2 pb-4">
                                        <pre>
@json($package['require-dev'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)
                                        </pre>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
@endsection
