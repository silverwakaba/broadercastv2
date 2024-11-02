@extends('layout.app')
@section('title', 'Recover')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <form id="theRecoverForm" method="POST">
                <div class="form-row">
                    <x-form.input name="email" type="email" text="Email" />
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <x-form.checkbox name="terms" value="1">I agree to <a href="https://help.silverspoon.me/docs/vtual/authentication/recovery" target="_blank">Account Recovery</a> policy</x-form.checkbox>
                    </div>
                    <div class="col-4">
                        <x-Form.Hcaptcha id="theRecoverForm" button="Recover" class="btn btn-block btn-primary" />
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <div class="row">
                    <div class="col-6">
                        <p><a href="{{ route('register') }}" class="btn btn-block btn-secondary">Register new account</a></p>
                    </div>
                    <div class="col-6">
                        <p><a href="{{ route('login') }}" class="btn btn-block btn-success">Login with an existing account</a></p>
                    </div>
                </div>
            </div>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection