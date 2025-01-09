@extends('layout.app')
@section('title', 'Followed Creator')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.CardForm title="Search" button="Search">
            <x-form.input name="name" type="text" :value="request()->name" text="Name" />
        </x-Adminlte.CardForm>
        <x-Adminlte.Card>
            <x-Adminlte.CardRels col="2" :rels="$datas" />
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection