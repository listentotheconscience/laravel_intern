@extends('layout')

@section('content')
    <div class="container">
        <br>
        <br>
        <h3 style="text-align: center">List of authors</h3>
        @forelse($authors as $author)
            <br>
            <div class="paragraphs">
                <div class="row">
                    <div class="span4">
                        <a href="{{ route('author.profile', ['id' => $author->id]) }}">
                            <img style="float:left; margin-right: 15px;" class="rounded-circle" width="64" height="64" src="{{ "http://localtest.com/storage/". $author->avatar }}"/>
                        </a>
                        <p style="margin-top: 20px;">{{ $author->name }}</p>
                    </div>
                </div>
            </div>

        @empty
            <p>No authors!</p>
        @endforelse
    </div>
    {{ $authors->links() }}
@endsection
