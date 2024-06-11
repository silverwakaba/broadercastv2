@extends('layout.app')
@section('title', 'Reset')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <form method="POST">
                <div class="form-row">
                    <x-form.input name="token" type="text" text="Token" :value="$datas->token" readonly />
                    <x-form.input name="new_password" type="password" text="New Password" />
                    <x-form.input name="new_password_confirmation" type="password" text="New Password Confirmation (Retype)" />
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <input type="hidden" name="email" class="d-none" value="{{ $datas->belongsToUser->email }}" readonly />
                        <x-form.checkbox name="terms" value="1">I agree to <a href="https://www.google.com">Blabla</a></x-form.checkbox>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-block btn-danger" type="submit">Reset</button>
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