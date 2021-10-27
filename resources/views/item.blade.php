@extends('layout')

@section('content')
    <div class="container">
        <img src="{{ asset($post->image) }}" alt="" class="img-thumbnail" width="200" height="200">
        <div class="row md-col-12">
            <p class="md-col-4">Date: {{ date('d M Y', strtotime($post->created_at)) }}</p>
            <p class="md-col-3">Title: {{ $post->title }}</p>
            <p class="md-col-3">Description: {{ $post->description }}</p>
            <p class="md-col-3">Author: {{ \App\Models\Author::find($post->author_id)->name }}</p>
            <p class="md-col-3">Hash: {{ $post->hashed_link }}</p>
            <a class="col-1 btn btn-primary" href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</a>
        </div>
    </div>
@endsection
