@extends('layout.app')
@section('title', 'Edit Existing User')
@section('content')
    <x-adminlte.content previous="apps.master.user.index">
        <x-adminlte.cardform button="Edit">
            <x-form.input name="email" type="email" text="Email" :value="$datas->email" />
            <x-form.input name="current_password" type="password" text="Current Password" />
            <x-form.input name="new_password" type="password" text="New Password" />
            <x-form.input name="new_password_confirmation" type="password" text="New Password Confirmation (Retype)" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection