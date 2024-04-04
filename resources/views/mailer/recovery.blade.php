@extends('layout.email')
@section('content')
    <p>You can recover your account by clicking on the link below:</p>
    <p><a href="{{ route('reset', ['id' => $token]) }}" target="_blank">{{ route('reset', ['id' => $token]) }}</a></p>
    <p>If you did not request for account recovery, please change your password immediately.</p>
@endsection