@extends('layout.app')
@section('title', 'Edit Affiliation')
@section('content')
    <x-Adminlte.Content :previous="route('apps.base.affiliation.index')">
        <x-Adminlte.CardForm button="Edit">
            <x-Form.Input name="name" type="text" text="Name" :value="$data->name" />
            <x-Form.Textarea name="about" text="About" :value="$data->about" placeholder="Tell us about this affiliation..." />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection