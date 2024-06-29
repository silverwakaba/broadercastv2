@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-lg-4">
                <x-Adminlte.CardProfile :profile="$profile" :links="$link" :channels="$tracker->data" />
            </div>
            <div class="col-lg-8">
                <x-Adminlte.Card tab="Live, Scheduled, Archived, Uploaded">
                    <x-slot name="tabContent">
                        <div class="tab-pane active" id="tab_0">
                            <x-Adminlte.CardFeed col="4" :feeds="$live" />
                        </div>
                        <div class="tab-pane" id="tab_1">
                            <x-Adminlte.CardFeed col="4" :feeds="$schedule" />
                        </div>

                        <div class="tab-pane" id="tab_1">
                            <x-Adminlte.CardFeed col="4" :feeds="$archive" />
                        </div>
                        <div class="tab-pane" id="tab_1">
                            <x-Adminlte.CardFeed col="4" :feeds="$uploaded" />
                        </div>

                    </x-slot>
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection