@extends('layout.app')
@section('title', 'Live Content')
@section('content')
    <x-Adminlte.Content previous="index">
        <x-Adminlte.Card title="Newest Live Content">
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection