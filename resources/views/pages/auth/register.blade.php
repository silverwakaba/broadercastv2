@extends('layout.app')
@section('title', 'Register')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Callout class="info">
            <h5>A notes about your password!</h5>
            <p>For account security, the password you use must meet the following requirements:</p>
            <ol>
                <li>Password must be at least 8 characters.</li>
                <li>Password must be at least contain a symbol.</li>
                <li>Password must be at least contain one uppercase and one lowercase letter.</li>
            </ol>
            <p>If you fail to follow these requirements, a more detailed error message will appear.</p>
        </x-Adminlte.Callout>
        <x-Adminlte.Card>
            <form id="theRegisterForm" method="POST">
                <div class="form-row">
                    <x-form.input name="email" type="email" text="Email" />
                    <x-form.input name="password" type="password" text="Password" />
                    <x-form.input name="password_confirmation" type="password" text="Password Confirmation (Retype)" />
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <x-form.checkbox name="terms" value="1">I agree to <a href="https://help.silverspoon.me/docs/vtual/tos" target="_blank">Terms</a> and <a href="https://help.silverspoon.me/docs/vtual/privacy" target="_blank">Privacy</a></x-form.checkbox>
                    </div>
                    <div class="col-md-4">
                        <x-Form.Hcaptcha id="theRegisterForm" button="Register" class="btn btn-block btn-primary" />
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
            <p>Have concerns about registering using email? Read our statement about <a href="https://help.silverspoon.me/docs/vtual/privacy#registering" target="_blank">registering anonymously</a>.</p>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection