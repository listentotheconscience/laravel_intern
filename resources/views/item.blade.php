@extends('layout')

@section('content')
    <div class="container">
        <img src="{{"http://localtest.com/storage/". $post->image }}" alt="" class="img-thumbnail" width="200" height="200">
        <div class="row md-col-12">
            <p class="md-col-4">Date: {{ date('d M Y', strtotime($post->created_at)) }}</p>
            <p class="md-col-3">Title: {{ $post->title }}</p>
            <p class="md-col-3">Description: {{ $post->description }}</p>
            <p class="md-col-3">Author: {{ \App\Models\Author::find($post->author_id)->name }}</p>
            <p class="md-col-3">Hash: {{ $post->hashed_link }}</p>
            <p class="md-col-3">Post ID: {{ $post->id }}</p>
            <p class="md-col-3">Visitors: {{ $visitors }}</p>
            <a class="col-1 btn btn-primary" href="{{ route('post.delete', ['id' => $post->id]) }}">Delete</a>
        </div>
        <hr>
        <h3 style="text-align: center">Comments</h3>

        @auth
        <form action="{{ route('comment.create') }}" method="POST" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <input type="hidden" name="author_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="mb-3 row">
                <div class="col-4">
                    <textarea style="resize: none" name="text" id="text" class="form-control" placeholder="Put your text here..." required ></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <button type="submit" class="btn btn-dark mb-3">Create Comment</button>
                </div>
            </div>
        </form>
        <hr>
        @endauth

        @forelse($comments as $comment)
            @if($comment->commentable_type == 'App\\Models\\Author')
                <div class="row md-col-12">
                    <p style="color: darkcyan" class="md-col-3">Author username: {{ \App\Models\Author::find($comment->commentable_id)->name }}</p>
                    <p style="color: darkcyan" class="md-col-3">Text: {{ $comment->text }}</p>
                </div>
            @else
                <div class="row md-col-12">
                    <p class="md-col-3">Author username: {{ \App\Models\User::find($comment->commentable_id)->name }}</p>
                    <p class="md-col-3">Text: {{ $comment->text }}</p>
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->id == $comment->commentable_id)
                            <a class="col-1 mb-3 btn btn-dark" href="{{ route('comment.delete', ['id' => $comment->id]) }}">Delete</a>
                        @endif
                    @endauth
                </div>
            @endif
            @foreach($comment->replies as $reply)
                @if($reply->commentable_type == 'App\\Models\\Author')
                    <div class="row md-col-12" style="color: darkcyan;">
                        <p class="md-col-3">Reply author: {{ \App\Models\Author::find($reply->commentable_id)->name }}</p>
                        <p class="md-col-3">Text: {{ $reply->text }}</p>
                    </div>
                @else
                    <div class="row md-col-12">
                        <p class="md-col-3">Reply author: {{ \App\Models\User::find($reply->commentable_id)->name }}</p>
                        <p class="md-col-3">Text: {{ $reply->text }}</p>
                        @auth
                            @if(\Illuminate\Support\Facades\Auth::user()->id == $reply->commentable_id)
                                <a class="col-1 mb-3 btn btn-dark" href="{{ route('comment.delete', ['id' => $reply->id]) }}">Delete</a>
                            @endif
                        @endauth
                    </div>
                @endif
            @endforeach

            @auth
            <form action="{{ route('comment.create') }}" method="POST" enctype="multipart/form-data">
                    @method("POST")
                    @csrf
                    <input type="hidden" name="author_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="mb-3 row">
                        <div class="col-4">
                            <textarea style="resize: none" name="text" id="text" class="form-control" placeholder="Put your text here..." required ></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-dark mb-3">Relpy</button>
                        </div>
                    </div>
                </form>
            <br />
            <hr/>
            @endauth

        @empty
            <p>No comments!</p>
        @endforelse
        {{ $comments->links() }}
    </div>
@endsection
