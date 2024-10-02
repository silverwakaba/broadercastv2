@extends('layout.front')
@section('title', 'Archived Content')
@section('content')
    <x-Valkivid.Container.Main>
        <x-Valkivid.Live.Content title="Past and Archived Content" :feeds="$datas" />
    </x-Valkivid.Container.Main>
@endsection