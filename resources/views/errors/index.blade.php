@extends('devtools::master')

@section('page', (request()->get('warning') ? 'Warnings' : 'Errors'))

@section('content')
    <div class="mb-3">
        <a href="{{ $urls['clear'] }}" class="btn btn-danger">Clear</a>
        <a href="{{ $urls['clearOld'] }}" class="btn btn-warning">Clear Old</a>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-striped table-hover">
            <tr>
                <th>Error</th>
                <th>Count</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            <tbody>
            @foreach($errorLogs as $id => $error)
                <tr>
                    <td>
                        <a href="{{ $error['previewUrl'] }}" class="d-block" target="_blank">{{ $error['error'] ?: ':|' }}</a>
                    </td>
                    <td>{{ $error['count'] }}</td>
                    <td>
                        <span class="text-muted">{!! nl2br($error['time'] ?? '-') !!}</span>
                    </td>
                    <td>
                        <a href="{{ $error['removeUrl'] }}" class="text-danger">Remove</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
