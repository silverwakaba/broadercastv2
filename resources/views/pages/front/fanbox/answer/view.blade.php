@extends('layout.app')
@section('title', $datas->title)
@section('description', "Answer and give your opinion about the fanbox created by " . $datas->user->name . " regarding the topic of $datas->title")
@section('content')
    <x-Adminlte.Content :title="$datas->title">
        <x-Adminlte.Callout class="info">
            <h5>Notes before answering!</h5>
            <ol class="m-0">
                <li>Please be ethical when filling out this form.</li>
                <li>You can answer this form anonymously without having to login to the system.</li>
                <li>You can also answer this form anonymously even though you are login into the system using your account.</li>
                <li>After successfully answering this form you will be redirected to a new page where you can edit your answers.</li>
            </ol>
        </x-Adminlte.Callout>
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-fluid img-circle" src="{{ $datas->avatar->path }}">
                    <div class="username">By {{ $datas->user->name }}</div>
                    <div class="description">
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">On {{ $datas->created_at }}</li>
                            <li class="list-inline-item">Public: {!! $datas->public !!}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $datas->description !!}
            </div>
        </div>
        <x-Adminlte.CardForm button="Answer" captcha="1">
            @auth
                <x-Form.Select2n name="anonymous" text="Answer as Anonymous" :data="$boolean" grab="value" />
            @endauth
            <x-Form.Textarea name="answer" text="Answer" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection