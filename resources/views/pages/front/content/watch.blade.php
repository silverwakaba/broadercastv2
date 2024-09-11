@extends('layout.app')
@section('title', 'Judul Stream')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card>
            <div class="row">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/g6D-46U6SOM"></iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/live_chat?v=g6D-46U6SOM&embed_domain=broadercast.test&dark_theme=1"></iframe>
                    </div>
                </div>
                <div class="col-md-12">
                    ABC
                </div>
            </div>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection