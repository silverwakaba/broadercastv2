@extends('layout.app')
@section('title', 'Change Your Gender Representation')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change">
            <x-form.select name="gender[]" text="Gender" :data="$datas" :value="$value" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection