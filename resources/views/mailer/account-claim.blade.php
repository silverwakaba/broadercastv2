@extends('layout.email')
@section('content')
    <p>You can complete your account claim by clicking on the link below:</p>
    <p><a href="{{ route('claim', ['id' => $token]) }}" target="_blank">{{ route('claim', ['id' => $token]) }}</a></p>
    <p>If you did not request for account claim, please delete this email as someone may have just made a big mistake.</p>
@endsection