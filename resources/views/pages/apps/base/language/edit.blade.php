@extends('layout.app')
@section('title', 'Edit Language Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.language.index">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="name" type="text" :value="$data->name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection