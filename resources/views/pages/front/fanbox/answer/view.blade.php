@extends('layout.app')
@section('title', $datas->title)
@section('content')
    <x-Adminlte.Content :title="$datas->title">
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
        <x-Adminlte.CardForm button="Answer">
            @auth
                <x-Form.Select2n name="anonymous" text="Answer as Anonymous" :data="$boolean" grab="value" />
            @endauth
            <x-Form.Textarea name="answer" text="Answer" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection