@extends('layout')        <hr>
        <h3 style="text-align: center">Posts of this author</h3>
        @forelse($posts as $post)
            <img src="{{ asset($post->image) }}" alt="" class="img-thumbnail" width="100" height="100">
            <div class="row md-col-12">
                <p class="md-col-4">Date: {{ date('d M Y', strtotime($post->created_at)) }}</p>
                <p class="md-col-3">Title: {{ $post->title }}</p>
                <p class="md-col-3">Description: {{ $post->description }}</p>
                <p class="md-col-3">Hash: {{ $post->hashed_link }}</p>
                <a class="col-1 btn btn-primary" href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</a>
                <br />
                <a class="col-1 btn btn-primary" href="{{ route('post.hash', ['hash' => $post->hashed_link]) }}">Show</a>
            </div>
            <br />
            <hr/>
            {{ $posts->links() }}
        @empty
            <p>No posts!</p>
        @endforelse


@section('content')
<div class="container">
    <br>
    <br>
    <div class="paragraphs">
        <div class="row">
            <div class="span4">
                <img style="float:left; margin-right: 15px;" class="rounded-circle" width="64" height="64" src="{{ url($author->avatar) }}"/>
                <p style="margin-top: 20px;">{{ $author->name }}</p>
            </div>
        </div>
    </div>
    <hr>
    <h3 style="text-align: center">Posts of this author</h3>
    @forelse($posts as $post)
        <img src="{{ asset($post->image) }}" alt="" class="img-thumbnail" width="100" height="100">
        <div class="row md-col-12">
            <p class="md-col-4">Date: {{ date('d M Y', strtotime($post->created_at)) }}</p>
            <p class="md-col-3">Title: {{ $post->title }}</p>
            <p class="md-col-3">Description: {{ $post->description }}</p>
            <p class="md-col-3">Hash: {{ $post->hashed_link }}</p>
            <a class="col-1 btn btn-primary" href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</a>
            <br />
            <a class="col-1 btn btn-primary" href="{{ route('post.hash', ['hash' => $post->hashed_link]) }}">Show</a>
        </div>
        <br />
        <hr/>
        {{ $posts->links() }}
    @empty
        <p>No posts!</p>
    @endforelse
</div>
@endsection
