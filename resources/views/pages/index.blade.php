@extends('layout.front')
@section('title', 'Content Creator Library')
@section('content')
    <x-Valkivid.Hero.Wakacosplay />
    <x-Valkivid.Container.Main>
        <x-Valkivid.Live.Content title="Live" :feeds="$live" link="{{ route('content.live') }}" />
        <x-Valkivid.Live.Content title="Scheduled" :feeds="$schedule" link="{{ route('content.scheduled') }}" />
        <x-Valkivid.Misc.Recommendation />
    </x-Valkivid.Container.Main>
@endsection