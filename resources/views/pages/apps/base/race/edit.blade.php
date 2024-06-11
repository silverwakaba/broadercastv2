@extends('layout.app')
@section('title', 'Edit Race Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.race.index">
        <x-Adminlte.CardForm button="Edit">
            <x-form.Input name="name" type="text" text="Name" :value="$data->name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection