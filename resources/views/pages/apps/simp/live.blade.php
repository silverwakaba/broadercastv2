@extends('layout.app')
@section('title', 'Live Content')
@section('content')
    <x-Adminlte.Content :previous="route('apps.simp.index')">
        <x-Adminlte.Callout class="info">
            <h5>Notes before simping!</h5>
            <ol class="m-0">
                <li>This page only showcasing live streaming content from the creators you follow.</li>
                <li>Follow different creators for more content.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.Card title="Newest Live Content">
            <x-Adminlte.CardFeed col="3" :feeds="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection