@extends('layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
        <p class="text-center fs-2">Create Post</p>
        <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <div class="mb-3 row">
                <div class="col-4">
                    <label for="title" class="form-label">Enter title: </label>
                    <input name="title" type="text" id="title" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <label for="description" class="form-label">Enter description: </label>
                    <input name="description" type="text" id="description" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <select class="form-select" aria-label="Select author" name="author_id">
                        <option selected>Select author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
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

