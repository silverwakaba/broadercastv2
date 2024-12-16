@extends('layout.app')
@section('title', 'Add New Proxy Host')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.proxy.host.index')">
        <x-Adminlte.Card>
            <strong>Currently disabled/TBA due to HA principle.</strong>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection