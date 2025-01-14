@extends('layout.app')
@section('title', 'Add New Persona Type')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.persona.index')">
        <x-Adminlte.CardForm button="Add">
            <x-form.Input name="name" type="text" text="Name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection