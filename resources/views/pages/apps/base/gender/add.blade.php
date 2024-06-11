@extends('layout.app')
@section('title', 'Add New Gender Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.gender.index">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Input name="name" type="text" text="Name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection