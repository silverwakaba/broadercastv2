@extends('layout.app')
@section('title', 'Content Creator Library')
@section('content')
    <x-Adminlte.Content title="Home">
        <x-Adminlte.Card title="Latest Activity" tab="Live, Upcoming">
            <x-slot name="tabContent">
                <div class="tab-pane active" id="tab_0">
                    <x-Adminlte.CardFeed col="4" :feeds="$live" />
                    <a href="{{ route('discover.live') }}" class="btn btn-block btn-outline-light">Load more live content...</a>
                </div>
                <div class="tab-pane" id="tab_1">
                    <x-Adminlte.CardFeed col="4" :feeds="$schedule" />
                    <a href="{{ route('discover.scheduled') }}" class="btn btn-block btn-outline-light">Load more scheduled live...</a>
                </div>
            </x-slot>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection