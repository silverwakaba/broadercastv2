@extends('layout.email')
@section('content')
    <p>Since you're activating 2FA, now you can login securely to your account by clicking on the link below in the next 5 minutes:</p>
    <p><center><a href="{{ $routeTo }}" target="_blank">{{ $routeTo }}</a></center></p>
    <p>If you did not make a login attempt, please change your password immediately as this may be an indication that someone is trying to access your account.</p>
@endsection