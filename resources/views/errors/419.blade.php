@extends('layout.app')
@section('title', 'Page Expired')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page expired.</h3>
                    <img src="{{ config('app.cdn_public_url') . '/system/image/misc/wakava/batch1/wakava-(4)-320x320.png' }}" class="img-fluid my-4" />
                    <p>Consuming something expired is not good.</p>
                    <button class="btn btn-md btn-light" onclick="location.reload()">Reload This Page Now</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection