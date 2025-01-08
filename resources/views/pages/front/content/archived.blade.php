@extends('layout.app')
@section('title', 'Archived Content')
@section('description', "Stay connected with our dynamic content library center! Catch up with past livestream by various content creator. Do not lose track anymore with their latest topic!")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <x-Adminlte.CardFeed col="4" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection