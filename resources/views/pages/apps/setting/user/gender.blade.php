@extends('layout.app')
@section('title', 'Change Your Gender Representation')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Select2m name="gender[]" text="Gender" :data="$datas" :value="$value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection