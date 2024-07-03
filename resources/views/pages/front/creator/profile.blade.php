@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-lg-4">
                <x-Adminlte.CardProfile :profile="$profile" :links="$link" :channels="$tracker->data" />
            </div>
            <div class="col-lg-8">
                <x-Adminlte.Card title="Content">
                    <x-Adminlte.CardFeed col="3" :feeds="$feed" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection