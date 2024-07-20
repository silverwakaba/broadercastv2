@extends('layout.app')
@section('title', 'Change Your Main Language')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Select2m name="language[]" text="Language" :data="$datas" :value="$value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection