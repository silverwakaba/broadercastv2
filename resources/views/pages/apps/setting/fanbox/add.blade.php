@extends('layout.app')
@section('title', 'Add New Fanbox')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Select2n name="public" text="Public" :data="$boolean" grab="value" />
            <x-Form.Input name="title" type="text" text="Title" />
            <x-Form.Textarea name="description" text="Description" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection