@extends('layout.app')
@section('title', 'Change Avatar')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change" encode="upload">
            <x-form.file name="avatar" text="Avatar" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection