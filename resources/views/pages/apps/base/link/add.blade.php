@extends('layout.app')
@section('title', 'Add New Link Type')
@section('content')
    <x-Adminlte.Content previous="apps.base.link.index">
        <x-Adminlte.CardForm button="Add">
            <x-Form.Input name="name" type="text" text="Name" />
            <x-Form.Input name="icon" type="text" text="Icon" />
            <x-Form.Input name="color" type="text" text="Color" />
            <x-Form.Checkbox name="checking" value="1">Need to be checked</x-Form.Checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection