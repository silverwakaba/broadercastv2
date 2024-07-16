@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-xl-4">
                <x-Adminlte.CardProfile :profile="$profile" :links="$link" :channels="$tracker" />
            </div>
            <div class="col-xl-8">
                <x-Adminlte.Card title="Content">
                    <x-Adminlte.CardFeed col="3" :feeds="$feed" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection