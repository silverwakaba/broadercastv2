@extends('layout.app')
@section('title', 'Edit Fanbox')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Select2n name="active" text="Active" :data="$boolean" grab="value" :value="$datas->active" />
            <x-Form.Select2n name="public" text="Public" :data="$boolean" grab="value" :value="$datas->public" />
            <x-Form.Input name="title" type="text" text="Title" :value="$datas->title" />
            <x-Form.Textarea name="description" text="Description" :value="$datas->description" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection