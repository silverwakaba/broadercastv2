@extends('layout.app')
@section('title', 'Content Creator Library')
@section('content')
    <x-Adminlte.Content title="Home">
        <div class="row">
            <div class="col-12 col-lg-9">
                <x-Adminlte.Card title="Latest Activity">
                    <x-Adminlte.CardFeed col="3" :feeds="$feed" />
                </x-Adminlte.Card>
            </div>
            <div class="col-12 col-lg-3">
                <x-Adminlte.Card title="Information Board">
                    <!--  -->
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection