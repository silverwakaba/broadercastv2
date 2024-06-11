@extends('layout.app')
@section('title', 'Add New Race Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.race.index">
        <x-Adminlte.CardForm button="Add">
            <x-form.Input name="name" type="text" text="Name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection