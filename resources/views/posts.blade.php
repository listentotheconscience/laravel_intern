@extends('layout')

@section('content')
    <div class="container">
        @forelse($posts as $post)
            <div class="row md-col-12">
                <p class="md-col-4">Date: {{ date('d M Y', strtotime($post->created_at)) }}</p>
                <p class="md-col-3">Title: {{ $post->title }}</p>
                <p class="md-col-3">Description: {{ $post->description }}</p>
                <p class="md-col-3">Author: {{ \App\Models\Author::find($post->author_id)->name }}</p>
                <a class="col-1 btn btn-primary" href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</a>
                <br>
                <a class="col-1 btn btn-primary" href="{{ route('post.hash', ['hash' => $post->hashed_link]) }}">Show</a>
            </div>
            <br />
            <hr/>
        @empty
            <p>No posts!</p>
        @endforelse
    </div>
    {{ $posts->links() }}
@endsection
