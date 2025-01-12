@extends('layout.app')
@section('title', 'Change Handler')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Input name="handler" type="text" text="Handler" :value="$handler" placeholder="Your new @handler" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection