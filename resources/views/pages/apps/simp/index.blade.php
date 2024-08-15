@extends('layout.app')
@section('title', 'Timeline')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Callout class="info">
            <h5>Notes before simping!</h5>
            <ol class="m-0">
                <li>This page only showcasing the three latest live streaming and scheduled content from the creators you follow.</li>
                <li>Follow different creators for more content.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.Card title="Latest Activity" tab="Live, Upcoming">
            <x-slot name="tabContent">
                <div class="tab-pane active" id="tab_0">
                    <x-Adminlte.CardFeed col="3" :feeds="$live" />
                    <a href="{{ route('apps.simp.live') }}" class="btn btn-block btn-outline-light">Load more live content...</a>
                </div>
                <div class="tab-pane" id="tab_1">
                    <x-Adminlte.CardFeed col="3" :feeds="$schedule" />
                    <a href="{{ route('apps.simp.scheduled') }}" class="btn btn-block btn-outline-light">Load more scheduled live...</a>
                </div>
            </x-slot>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection