@extends('devtools::master')

@section('page', 'Tools result')

@section('content')
    <div class="mb-5">
        <div class="jumbotron text-center text-muted">
            <code>{{ $result }}</code>
        </div>
    </div>
@endsection
