@extends('layout.app')
@section('title', 'Login')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <form action="{{ url()->current() }}" method="POST">
                <div class="form-row">
                    <x-form.input name="email" type="email" text="Email" />
                    <x-form.input name="password" type="password" text="Password" />
                </div>
                <div class="row">
                    <div class="col-8">
                        <input type="hidden" name="_token" class="d-none" value="{{ csrf_token() }}" readonly />
                        <x-form.checkbox name="remember" value="1">Remember Me</x-form.checkbox>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-block btn-primary" type="submit">Login</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <div class="row">
                    <div class="col-6">
                        <p><a href="{{ route('register') }}" class="btn btn-block btn-secondary">Join the broaderhood</a></p>
                    </div>
                    <div class="col-6">
                        <p><a href="{{ route('recover') }}" class="btn btn-block btn-danger">Recover my broaderhood access</a></p>
                    </div>
                </div>
            </div>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection