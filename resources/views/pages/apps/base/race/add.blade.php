@extends('layout.app')
@section('title', 'Add New Base Race')
@section('content')
    <x-adminlte.content previous="apps.base.race.index">
        <x-adminlte.cardform button="Add">
            <x-form.input name="name" type="text" text="Name" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection