@extends('layout.app')
@section('title', 'Change Avatar')
@section('content')
    <x-Adminlte.Content previous="apps.manager.index">
        <x-Adminlte.CardForm button="Change" encode="upload">
            <x-Form.File name="avatar" text="Avatar" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection