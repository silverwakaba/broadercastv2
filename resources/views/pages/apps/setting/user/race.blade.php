@extends('layout.app')
@section('title', 'Change Your Character Persona')
@section('content')
    <x-Adminlte.Content previous="apps.manager.index">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Select2m name="race[]" text="Persona" :data="$datas" :value="$value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection