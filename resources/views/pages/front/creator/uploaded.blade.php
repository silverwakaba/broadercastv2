@extends('layout.app')
@section('title', 'VOD Content')
@section('content')
    <x-Adminlte.Content :previous="route('index')">
        <x-Adminlte.Card title="Video on Demand Content">
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection