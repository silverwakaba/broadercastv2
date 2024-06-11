@extends('layout.app')
@section('title', 'Change Your Focus Content')
@section('content')
    <x-Adminlte.Content previous="apps.manager.index">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Select2m name="content[]" text="Content" :data="$datas" :value="$value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection