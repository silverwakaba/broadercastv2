@extends('layout.app')
@section('title', 'Edit Content Type')
@section('content')
    <x-adminlte.content previous="apps.base.content.index">
        <x-adminlte.cardform button="Edit">
            <x-form.input name="name" type="text" text="Name" :value="$data->name" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection