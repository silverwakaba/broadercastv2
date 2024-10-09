@extends('layout.app')
@section('title', 'Not Found')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                    <img src="{{ config('app.cdn_static_url') . '/system/internal/image/misc/wakava/batch1/wakava-(4)-320x320.png' }}" class="img-fluid my-4">
                    <p>What are you looking for anyway?</p>
                    <button class="btn btn-md btn-light" onclick="history.back()">Go Back Now</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection