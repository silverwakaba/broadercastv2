@extends('layout.app')
@section('title', 'Add New User')
@section('content')
    <x-adminlte.content previous="apps.master.user.index">
        <x-adminlte.cardform button="Add">
            <x-form.input name="name" type="text" text="Name" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection