@extends('layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
        @isset($errors)
            @foreach($errors as $error)
                <p>{{$error}}</p>
            @endforeach
        @endisset
        <form action="{{ route('auth.signin') }}" method="POST" enctype="multipart/form-data">
            @method("POST")
            @csrf
            <div class="mb-3 row">
                <div class="col-4">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <label for="name" class="form-label">Enter username: </label>
                    <input name="name" type="text" id="name" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <label for="email" class="form-label">Enter email: </label>
                    <input name="email" type="email" id="email" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                    <label for="password" class="form-label">Enter password: </label>
                    <input name="password" type="password" id="password" class="form-control" required/>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4">
                    <label for="image" class="form-label">Select an image: </label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4">
                    <button type="submit" class="btn btn-dark mb-3">Sign In</button>
                </div>
            </div>
        </form>
    </div>
@endsection
