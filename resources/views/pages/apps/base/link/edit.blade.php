@extends('layout.app')
@section('title', 'Edit Link Type')
@section('content')
    <x-adminlte.content previous="apps.base.link.index">
        <x-adminlte.cardform button="Edit">
            <x-form.input name="name" type="text" text="Name" :value="$data->name" />
            <x-form.input name="icon" type="text" text="Icon" :value="$data->icon" />
            <x-form.input name="color" type="text" text="Color" :value="$data->color" />
            <x-form.checkbox name="checking" value="1" :values="$data->checking">Need to be checked</x-form.checkbox>
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection