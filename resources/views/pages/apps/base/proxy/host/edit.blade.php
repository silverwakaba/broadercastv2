@extends('layout.app')
@section('title', 'Edit Proxy Type')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.proxy.type.index')">
        <x-Adminlte.Card>
            <strong>Currently disabled/TBA due to HA principle.</strong>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection