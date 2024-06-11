@extends('layout.app')
@section('title', 'Edit Content Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.content.index">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="name" type="text" text="Name" :value="$data->name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection