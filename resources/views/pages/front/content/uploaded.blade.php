@extends('layout.app')
@section('title', 'VOD Content')
@section('description', "Stay connected with our dynamic content library center! Dive into our extensive VOD library by various content creator. Join the action now!")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection