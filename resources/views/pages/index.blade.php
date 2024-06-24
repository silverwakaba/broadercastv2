@extends('layout.app')
@section('title', 'Content Creator Library')
@section('content')
    <x-Adminlte.Content title="Home">
        <div class="row">
            <div class="col-12 col-lg-9">
                <x-Adminlte.Card title="Latest Activity" tab="Live, Upcoming, Archive, Upload">
                    <x-slot name="tabContent">
                        <div class="tab-pane active" id="tab_0">
                            <x-Adminlte.CardFeed col="3" :feeds="$feedLive" />
                            <a href="{{ route('discover.live') }}" class="btn btn-block btn-outline-light">Load more live content...</a>
                        </div>
                        <div class="tab-pane" id="tab_1">
                            <x-Adminlte.CardFeed col="3" :feeds="$feedUpcoming" />
                            <a href="{{ route('discover.scheduled') }}" class="btn btn-block btn-outline-light">Load more upcoming live...</a>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <x-Adminlte.CardFeed col="3" :feeds="$feedArchive" />
                            <a href="{{ route('discover.archived') }}" class="btn btn-block btn-outline-light">Load more archive content...</a>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <x-Adminlte.CardFeed col="3" :feeds="$feedUploaded" />
                            <a href="{{ route('discover.uploaded') }}" class="btn btn-block btn-outline-light">Load more uploaded content...</a>
                        </div>
                    </x-slot>
                </x-Adminlte.Card>
            </div>
            <div class="col-12 col-lg-3">
                <x-Adminlte.Card title="Information Board">
                    <!--  -->
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection