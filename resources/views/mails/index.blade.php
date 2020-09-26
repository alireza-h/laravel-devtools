@extends('devtools::master')

@section('page', 'Mails')

@section('content')
    <div class="mb-3">
        <a href="{{ $urls['clear'] }}" class="btn btn-danger">Clear</a>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless table-striped table-hover">
            <tr>
                <th>Subject</th>
                <th>To</th>
                <th>From</th>
                <th>Content-Type</th>
                <th>At</th>
                <th>Actions</th>
            </tr>
            <tbody>
            @foreach($mails as $id => $mail)
                <tr>
                    <td>
                        <a href="{{ route('devtools.mails.preview', ['id' => $mail->id]) }}" class="d-block" target="_blank">{{ $mail->subject ?: ':|' }}</a>
                    </td>
                    <td>{!! implode('<br>', array_keys($mail->to)) !!}</td>
                    <td>{!! implode('<br>', array_keys($mail->from)) !!}</td>
                    <td>{{ $mail->content_type }}</td>
                    <td>{{ $mail->created_at }}</td>
                    <td>
                        <a href="{{ route('devtools.mails.remove', ['id' => $mail->id]) }}" class="text-danger">Remove</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $mails->links() }}</div>
@endsection
