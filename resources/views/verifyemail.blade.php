@extends("layout")

@section("content")
    <h4>You need to verify your account</h4>
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit"><h5>Send Email</h5></button>
    </form>
@endsection
