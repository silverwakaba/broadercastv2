@extends('layout.app')
@section('title', 'Too Many Requests')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Too many requests.</h3>
                    <img src="https://pub.silverspoon.me/system/image/misc/wakava/batch1/wakava-(4)-320x320.png" class="img-fluid my-4" />
                    <p>Take a breath and calm down a little bit, will you?</p>
                    <button class="btn btn-md btn-light" onclick="history.back()">Go Back For Now</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection