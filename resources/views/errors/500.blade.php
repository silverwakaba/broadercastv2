@extends('layout.app')
@section('title', 'Server Error')
@section('content')
    <x-adminlte.content>
        <x-adminlte.card>
            <div class="error-page">
                <div class="error-content text-center">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Server error.</h3>
                    <img src="{{ config('app.cdn_public_url') . '/system/image/misc/wakava/batch1/wakava-(6)-320x320.png' }}" class="img-fluid my-4" />
                    <p>Oh shoot! Our server is having problems right now. Please wait a minute.</p>
                    <button class="btn btn-md btn-light" onclick="location.reload()">Try Again</button>
                </div>
            </div>
        </x-adminlte.card>
    </x-adminlte.content>
@endsection