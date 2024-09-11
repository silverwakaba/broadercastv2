@extends('layout.app')
@section('title', 'Scheduled Content')
@section('content')
    <x-Adminlte.Content :previous="route('index')">
        <x-Adminlte.Card title="Upcoming Scheduled Content">
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection