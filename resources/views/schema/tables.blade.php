@extends('devtools::master')

@section('page', 'Schema')

@section('content')
    <div class="mb-5">
        <div class="accordion" id="accordionCommand">

            @foreach($schema as $table => $data)

                <div class="card">
                    <div class="card-header" id="heading--{{ $table }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse--{{ $table }}" aria-expanded="true" aria-controls="collapse--{{ $table }}">
                                {{ $table }}
                            </button>
                        </h2>
                    </div>

                    <div id="collapse--{{ $table }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading--{{ $table }}" data-parent="#accordionCommand">
                        <div class="card-body">
                            <div class="pb-3">
                                <code>{{ $table }}</code>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-hover">
                                    <tr>
                                        @foreach(current($data['definition']) as $attribute => $value)
                                            <th>{{ $attribute }}</th>
                                        @endforeach
                                    </tr>
                                    <tbody>
                                        @foreach($data['definition'] as $field => $attributes)
                                            <tr>
                                                @foreach($attributes as $attribute => $value)
                                                    @if($loop->first)
                                                        <td>
                                                            <code>{{ $value ?? '-' }}</code>
                                                        </td>
                                                    @else
                                                        <td>{{ $value ?: '-' }}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if(!empty($data['indexes']))
                                <div class="pb-3 pt-5">
                                    <code>{{ $table }} indexes</code>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped table-hover">
                                        <tr>
                                            @foreach(current($data['indexes']) as $attribute => $value)
                                                <th>{{ $attribute }}</th>
                                            @endforeach
                                        </tr>
                                        <tbody>
                                        @foreach($data['indexes'] as $field => $attributes)
                                            <tr>
                                                @foreach($attributes as $attribute => $value)
                                                    @if($loop->first)
                                                        <td>
                                                            <code>{{ $value ?? '-' }}</code>
                                                        </td>
                                                    @else
                                                        <td>{{ $value ?: '-' }}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
@endsection
