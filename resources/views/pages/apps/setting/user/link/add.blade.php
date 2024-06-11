@extends('layout.app')
@section('title', 'Add New External Link')
@section('content')
    <x-Adminlte.Content previous="apps.manager.link">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Select2n name="service" text="Service" :data="$services" />
            <x-Form.Input name="link" type="url" text="Link" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection