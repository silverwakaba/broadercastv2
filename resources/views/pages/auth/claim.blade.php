@extends('layout.app')
@section('title', 'Claim ' . $datas->belongsToUser->name . ' Profile')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card title="Guideline">
            <div class="lead">
                <p>Thank you for following all the necessary procedures in the SGU account claim process. We are pleased to inform you that you have successfully completed the verification claim.</p>
                <p>On this page, you are required to set up a unique email address and a strong password that will be used to access your "<strong><u>{{ $datas->belongsToUser->name }}</u></strong>" account from now. It is important to choose an email that is distinct and to create a robust password to ensure the security of your account.</p>
                <p>In the event that you lose access to your account due to a forgotten password, please refer to the established regulations for recovery options. Your attention to these details will help safeguard your account and enhance your overall experience.</p>
                <p>If you have concerns about sharing your email address with us, plase read our statement about <a href="https://help.silverspoon.me/docs/vtual/privacy#registering" target="_blank">registering anonymously</a>.</p>
            </div>
        </x-Adminlte.Card>
        <x-Adminlte.Card title="Claim">
            <form id="theClaimForm" method="POST">
                <div class="form-row">
                    <x-form.input name="token" type="text" text="Token" :value="$datas->token" readonly />
                    <x-form.input name="new_email" type="email" text="New Email" />
                    <x-form.input name="new_password" type="password" text="New Password" />
                    <x-form.input name="new_password_confirmation" type="password" text="New Password Confirmation (Retype)" />
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <input type="hidden" name="email" class="d-none" value="{{ $datas->belongsToUser->email }}" readonly />
                        <x-form.checkbox name="terms" value="1">I agree to <a href="https://help.silverspoon.me/docs/vtual/authentication/claim" target="_blank">Account Claim</a> policy</x-form.checkbox>
                    </div>
                    <div class="col-4">
                        <x-Form.Hcaptcha id="theClaimForm" button="Claim" class="btn btn-block btn-primary" />
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