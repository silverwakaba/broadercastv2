@extends('layout.app')
@section('title', 'Add New User')
@section('content')
    <x-adminlte.content previous="apps.master.user.index">
        <x-adminlte.cardform button="Add">
            <x-form.input name="email" type="email" text="Email" />
            <x-form.input name="password" type="password" text="Password" />
            <x-form.input name="password_confirmation" type="password" text="Password Confirmation (Retype)" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection