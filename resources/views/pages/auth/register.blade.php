@extends('layout.app')
@section('title', 'Register')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <form method="POST">
                <div class="form-row">
                    <x-form.input name="email" type="email" text="Email" />
                    <x-form.input name="password" type="password" text="Password" />
                    <x-form.input name="password_confirmation" type="password" text="Password Confirmation (Retype)" />
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <x-form.checkbox name="terms" value="1">I agree to <a href="https://help.silverspoon.me/docs/silverspoon/tos" target="_blank">Terms</a> and <a href="https://help.silverspoon.me/docs/silverspoon/privacy" target="_blank">Privacy</a></x-form.checkbox>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-block btn-primary" type="submit">Register</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <div class="row">
                    <div class="col-12">
                        <p><a href="{{ route('login') }}" class="btn btn-block btn-success">Login with an existing account</a></p>
                    </div>
                </div>
            </div>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection