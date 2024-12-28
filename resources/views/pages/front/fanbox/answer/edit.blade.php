@extends('layout.app')
@section('title', $datas->fanbox->title)
@section('content')
    <x-Adminlte.Content :title="$datas->fanbox->title">
        <x-Adminlte.Callout class="info">
            <h5>Notes before editing the answer!</h5>
            <ol class="m-0">
                <li>Please be ethical when editing out this form.</li>
                <li>You can edit your answer as long as it has not been deleted by the form owner.</li>
                <li>Even though not publicly published, this page is publicly accessible. Please keep your answer ID confidential if you don't want your answer to be changed by others.</li>
                <li>In the next patch, you can upload attachments to your answer here.</li>
            </ol>
        </x-Adminlte.Callout>
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-fluid img-circle" src="{{ $datas->avatar->path }}">
                    <div class="username">By {{ $datas->userWhoAsked->name }}</div>
                    <div class="description">
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">On {{ $datas->fanbox->created_at }}</li>
                            <li class="list-inline-item">Public: {!! $datas->fanbox->public !!}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $datas->fanbox->description !!}
            </div>
        </div>
        <x-Adminlte.CardForm button="Edit" captcha="1">
            @auth
                <x-Form.Select2n name="anonymous" text="Answer as Anonymous" :data="$boolean" grab="value" :value="$datas->anonymous" />
            @endauth
            <x-Form.Textarea name="answer" text="Answer" :value="$datas->message" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection