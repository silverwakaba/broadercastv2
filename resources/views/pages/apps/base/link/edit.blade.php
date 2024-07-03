@extends('layout.app')
@section('title', 'Edit Link Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.link.index">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="name" type="text" text="Name" :value="$data->name" />
            <x-Form.Input name="icon" type="text" text="Icon" :value="$data->icon" />
            <x-Form.Input name="color" type="text" text="Color" :value="$data->color" />
            <x-Form.Checkbox name="checking" value="1" :values="$data->checking">Need to be checked</x-Form.Checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection