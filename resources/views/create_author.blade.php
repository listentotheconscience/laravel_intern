@extends('layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
        <p class="text-center fs-2">Create Author</p>
        <form action="{{ route('author.create') }}" method="POST" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <div class="mb-3 row">
                <div class="col-4">
                    <label for="name" class="form-label">Enter name: </label>
                    <input name="name" type="text" id="name" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <button type="submit" class="btn btn-primary mb-3">Create Post</button>
                </div>
            </div>
        </form>
    </div>
@endsection
