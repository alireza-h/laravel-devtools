@extends('devtools::master')

@section('page', 'Password')

@section('content')
    <div class="mb-3">
        <form method="post">
            @csrf
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Hash Password</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
