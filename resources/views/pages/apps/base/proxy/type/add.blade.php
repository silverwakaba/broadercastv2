@extends('layout.app')
@section('title', 'Add New Proxy Type')
@section('content')
    <x-Adminlte.Content previous="route('apps.base.proxy.type.index')">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Input name="name" type="text" text="Name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection