@extends('layout.app')
@section('title', 'VOD Content')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection