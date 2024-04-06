@extends('layout.app')
@section('title', 'Add New Base Gender')
@section('content')
    <x-adminlte.content previous="apps.base.gender.index">
        <x-adminlte.cardform button="Add">
            <x-form.input name="name" type="text" text="Name" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection