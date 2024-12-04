@extends('layout.app')
@section('title', 'Change Email')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change" captcha="1">
            <x-Form.Input name="email" type="email" text="Email" placeholder="Your new email" />
            <x-Form.Input name="password" type="password" text="Password" placeholder="Enter your password to confirm" />
            <x-form.checkbox name="terms" value="1">I know what I'm doing</x-form.checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection