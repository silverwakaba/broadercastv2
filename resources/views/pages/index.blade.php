@extends('layout.app')
@section('title', 'Content Creator Library')
@section('content')
    <x-Adminlte.Content title="Home">
        <x-Adminlte.Card title="Live">
            <x-Adminlte.CardFeed col="4" :feeds="$live" />
            <a href="{{ route('content.live') }}" class="btn btn-block btn-outline-light">Load more live content...</a>
        </x-Adminlte.Card>
        <x-Adminlte.Card title="Scheduled">
            <x-Adminlte.CardFeed col="4" :feeds="$schedule" />
            <a href="{{ route('content.scheduled') }}" class="btn btn-block btn-outline-light">Load more scheduled live...</a>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection