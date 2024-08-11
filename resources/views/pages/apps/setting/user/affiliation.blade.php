@extends('layout.app')
@section('title', 'Change Affiliation')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Select2m name="content[]" text="Content" :data="$datas" :value="$value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection