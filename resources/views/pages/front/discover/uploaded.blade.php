@extends('layout.app')
@section('title', 'VOD Content')
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-12 col-lg-3">
                <x-Adminlte.Card title="Search">
                    <!--  -->
                </x-Adminlte.Card>
            </div>
            <div class="col-12 col-lg-9">
                <x-Adminlte.Card title="Video on Demand Content">
                    <x-Adminlte.CardFeed col="3" :feeds="$datas" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection