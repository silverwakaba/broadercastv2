@extends('layout.app')
@section('title', 'Archived Content')
@section('content')
    <x-Adminlte.Content :previous="route('index')">
        <x-Adminlte.Card title="Past and Archived Content">
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection