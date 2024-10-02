@extends('layout.front')
@section('title', 'Live Content')
@section('content')
    <x-Valkivid.Container.Main>
        <x-Valkivid.Live.Content title="Live" :feeds="$datas" />
    </x-Valkivid.Container.Main>
@endsection