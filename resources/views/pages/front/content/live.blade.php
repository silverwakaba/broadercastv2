@extends('layout.app')
@section('title', 'Live Content')
@section('description', "Stay connected with our dynamic content library center! Catch ongoing livestream by various content creator. Join the content discovery now!")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection