@extends('layout.app')
@section('title', 'Scheduled Content')
@section('description', "Stay connected with our dynamic content library center! Catch upcoming and scheduled livestream by various content creator. Book your seat now!")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection