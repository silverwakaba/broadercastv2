@extends('layout.app')
@section('title', 'Edit Gender Type')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.gender.index')">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="name" type="text" text="Name" :value="$data->name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection