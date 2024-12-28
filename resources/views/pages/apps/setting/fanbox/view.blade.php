@extends('layout.app')
@section('title', $question->title)
@section('content')
    <x-Adminlte.Content :previous="$backURI" :title="$question->title">

        @if(($datas) && (count($datas->data) >= 1))
            @foreach($datas->data as $data)
                <div class="card card-primary card-outline card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <img class="img-fluid img-circle" src="{{ $data->avatar->path }}">
                            <div class="username">By {{ $data->userWhoAnswer->name }}</div>
                            <div class="description">
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">On {{ $data->created_at }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-tools">
                            <a href="{{ $datas->links->prev }}" title="Previous" @class(["btn btn-tool", "disabled" => $datas->links->prev == null])><i class="fas fa-chevron-left"></i></a>
                            <a href="{{ $datas->links->next }}" title="Next" @class(["btn btn-tool", "disabled" => $datas->links->next == null])><i class="fas fa-chevron-right"></i></a>
                            <a href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('apps.manager.fanbox.submission.delete', now()->addMinutes(5), ['id' => $question->identifier, 'did' => $data->id, 'page' => $datas->links->prev]) }}" class="btn btn-tool" title="Delete"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mailbox-read-message">
                            {!! $data->message !!}

                            {{ $data->count() }}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            KONTOL
        @endif
    </x-Adminlte.Content>
@endsection