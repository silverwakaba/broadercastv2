@extends('layout.email')
@section('content')
    <p>Since you're activating the 2FA feature, you can only access your account by authorizing each login attempt with a login token that is valid for 5 minutes:</p>
    <p><center><a href="{{ $routeTo }}" target="_blank">{{ $routeTo }}</a></center></p>
    <p>If you did not make a login attempt, please change your password immediately as this may be an indication that someone is trying to access your account.</p>
@endsection