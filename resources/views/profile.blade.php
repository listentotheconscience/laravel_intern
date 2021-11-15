@extends('layout')


@section('content')
    <div class="container">
        <br>
        <br>
        <div class="paragraphs">
            <div class="row">
                <div class="span4">
                    <img style="float:left; margin-right: 15px;" class="rounded-circle" width="128" height="128" src="{{ "http://localtest.com/storage/".$user->avatar }}"/>
                    <p style="margin-top: 40px; font-size: 32px;">{{ $user->name }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
