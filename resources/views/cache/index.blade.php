@extends('devtools::master')

@section('page', 'Cache')

@section('content')
    @foreach($tagGroups as $key => $tags)
        <div class="mb-5">
            <h4>{{ ucfirst($key) }}</h4>
            <form action="{{ route('dev.cache.flush') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <div class="input-group mb-3">
                        <select class="form-control" name="tag" id="tags">
                            <option value=""> - </option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag }}">{{ $tag }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-warning" type="submit">Flush</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach

    <div class="mb-5">
        <h4>Etc</h4>
        <form action="{{ route('dev.cache.flush') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="etc">Cache tag</label>
                <div class="input-group mb-3">
                    <input class="form-control" name="custom_tag" id="etc" />
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="submit">Flush</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="etc">Cache key</label>
                <div class="input-group mb-3">
                    <input class="form-control" name="custom_key" id="etc" />
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="submit">Flush</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
