@extends('layout.app')
@section('title', 'Timeline')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="3" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection