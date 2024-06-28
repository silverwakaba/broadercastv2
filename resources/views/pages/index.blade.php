@extends('layout.app')
@section('title', 'Content Creator Library')
@section('content')
    <x-Adminlte.Content title="Home">
        <x-Adminlte.Card title="Latest Activity" tab="Live, Upcoming, Archive, Upload">
            <x-slot name="tabContent">
                <div class="tab-pane active" id="tab_0">
                    <x-Adminlte.CardFeed col="4" :feeds="$feedLive" />
                    <a href="{{ route('discover.live') }}" class="btn btn-block btn-outline-light">Load more live content...</a>
                </div>
                <div class="tab-pane" id="tab_1">
                    <x-Adminlte.CardFeed col="4" :feeds="$feedUpcoming" />
                    <a href="{{ route('discover.scheduled') }}" class="btn btn-block btn-outline-light">Load more upcoming live...</a>
                </div>
                <div class="tab-pane" id="tab_2">
                    <x-Adminlte.CardFeed col="4" :feeds="$feedArchive" />
                    <a href="{{ route('discover.archived') }}" class="btn btn-block btn-outline-light">Load more archive content...</a>
                </div>
                <div class="tab-pane" id="tab_3">
                    <x-Adminlte.CardFeed col="4" :feeds="$feedUploaded" />
                    <a href="{{ route('discover.uploaded') }}" class="btn btn-block btn-outline-light">Load more uploaded content...</a>
                </div>
            </x-slot>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection