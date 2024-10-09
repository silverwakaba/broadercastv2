@extends('layout.app')
@section('title', 'Forbidden')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Forbidden area.</h3>
                    <img src="{{ config('app.cdn_static_url') . '/system/internal/image/misc/wakava/batch1/wakava-(3)-320x320.png' }}" class="img-fluid my-4">
                    <p>We're sorry but you can't continue.</p>
                    <button class="btn btn-md btn-light" onclick="history.back()">Go Back Now</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection