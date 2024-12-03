@extends('layout.email')
@section('content')
    <p>You can complete your account claim by clicking on the link below in the next 30 minutes:</p>
    <p><center><a href="{{ $routeTo }}" target="_blank">{{ $routeTo }}</a></center></p>
    <p>If you did not request for account claim, please delete this email as someone may have just made a big mistake.</p>
@endsection