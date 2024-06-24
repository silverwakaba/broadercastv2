@extends('layout.app')
@section('title', 'Service Unavailable')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Service unavailable.</h3>
                    <img src="https://pub.silverspoon.me/system/image/misc/wakava/batch1/wakava-(1)-320x320.png" class="img-fluid my-4" />
                    <p>We are preparing something so access is temporarily suspended.</p>
                    <button class="btn btn-md btn-light" onclick="location.reload()">Try Again</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection