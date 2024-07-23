@extends('layout.app')
@section('title', 'Edit Existing User')
@section('content')
    <x-Adminlte.Content previous="apps.master.user.index">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="email" type="email" text="Email" :value="$datas->email" />
            <x-Form.Input name="current_password" type="password" text="Current Password" />
            <x-Form.Input name="new_password" type="password" text="New Password" />
            <x-Form.Input name="new_password_confirmation" type="password" text="New Password Confirmation (Retype)" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection