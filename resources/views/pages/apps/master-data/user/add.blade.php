@extends('layout.app')
@section('title', 'Add New User')
@section('content')
    <x-Adminlte.Content previous="apps.master.user.index">
        <x-Adminlte.Cardform button="Add">
            <x-Form.Input name="name" type="text" text="Name" />
        </x-Adminlte.Cardform>
    </x-Adminlte.Content>
@endsection