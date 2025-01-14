@extends('layout.app')
@section('title', 'Edit Persona Type')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.persona.index')">
        <x-Adminlte.CardForm button="Edit">
            <x-form.Input name="name" type="text" text="Name" :value="$data->name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection