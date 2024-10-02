@extends('layout.front')
@section('title', 'Scheduled Content')
@section('content')
    <x-Valkivid.Container.Main>
        <x-Valkivid.Live.Content title="Upcoming Scheduled Content" :feeds="$datas" />
    </x-Valkivid.Container.Main>
@endsection