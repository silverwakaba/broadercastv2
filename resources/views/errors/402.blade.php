@extends('layout.app')
@section('title', 'Payment Required')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Payment required.</h3>
                    <img src="{{ config('app.cdn_static_url') . '/system/internal/image/misc/wakava/batch1/wakava-(1)-320x320.png' }}" class="img-fluid my-4" />
                    <p>Give us money first, then we will allow access to this page.</p>
                    <button class="btn btn-md btn-light" onclick="history.back()">Go Back Now</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection