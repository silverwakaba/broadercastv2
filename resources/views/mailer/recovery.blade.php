@extends('layout.email')
@section('content')
    <p>You can recover your account by clicking on the link below in the next 30 minutes:</p>
    <p><center><a href="{{ $routeTo }}" target="_blank">{{ $routeTo }}</a></center></p>
    <p>If you did not request for account recovery, please change your password immediately as this may be an indication that someone is trying to take over your account.</p>
@endsection