@extends('layout.app')
@section('title', 'Add New Affiliation')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.affiliation.index')">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Textarea name="name" text="Name" placeholder="Bulk insert mode for affiliation" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection