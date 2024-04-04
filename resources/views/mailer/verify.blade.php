@extends('layout.email')
@section('content')
    <p>Please verify your email by clicking on the link below:</p>
    <p><a href="{{ route('verify', ['id' => $email]) }}" target="_blank">{{ route('verify', ['id' => $email]) }}</a></p>
    <p>If you did not create an account, no further action is required.</p>
@endsection