@extends('devtools::master')

@section('page', 'Tools')

@section('content')
    <div class="mb-5">
        <form method="post" class="mb-5">
            @csrf
            <div class="form-group">
                <input type="text" name="class" value="\App\" class="form-control mb-2" placeholder="Class">
                <input type="text" name="id" class="form-control mb-2" placeholder="ID">
                <input type="hidden" name="type" value="model">
                <div class="input-group mb-3">
                    <input type="text" name="with" class="form-control" placeholder="With">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Dump Model</button>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" class="mb-5" action="{{ route('devtools.tools.post.login-as') }}">
            @csrf
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="hidden" name="type" value="login_as">
                    <input type="text" name="id" class="form-control" placeholder="User ID">

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Login As</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
