@extends('layout.app')
@section('title', 'Edit Gender Type')
@section('content')
    <x-adminlte.content previous="apps.base.gender.index">
        <x-adminlte.cardform button="Edit">
            <x-form.input name="name" type="text" text="Name" :value="$data->name" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection