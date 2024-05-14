@extends('layout.app')
@section('title', 'Add New External Link')
@section('content')
    <x-adminlte.content previous="apps.manager.link">
        <x-adminlte.cardform button="Add">
            <x-form.select2n name="service" text="Service" :data="$services" />
            <x-form.input name="link" type="url" text="Link" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection