@extends('layout.app')
@section('title', 'Change Password')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change" captcha="1">
            <x-Form.Input name="current_password" type="password" text="Current Password" placeholder="Enter your current password to confirm" />
            <x-Form.Input name="new_password" type="password" text="New Password" placeholder="Enter your new password" />
            <x-Form.Input name="new_password_confirmation" type="password" text="New Password (Retype)" placeholder="Retype your new password to confirm" />
            <x-form.checkbox name="terms" value="1">I know what I'm doing</x-form.checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection