@extends('devtools::master')

@section('page', 'Commands output')

@section('content')
    <div class="mb-5">
        <div class="jumbotron">
            <pre>
                {!! $result !!}
            </pre>
        </div>
    </div>
@endsection
