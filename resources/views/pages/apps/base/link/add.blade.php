@extends('layout.app')
@section('title', 'Add New Link Type')
@section('content')
    <x-adminlte.content previous="apps.base.link.index">
        <x-adminlte.cardform button="Add">
            <x-form.input name="name" type="text" text="Name" />
            <x-form.input name="icon" type="text" text="Icon" />
            <x-form.input name="color" type="text" text="Color" />
            <x-form.checkbox name="checking" value="1">Need to be checked</x-form.checkbox>
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection