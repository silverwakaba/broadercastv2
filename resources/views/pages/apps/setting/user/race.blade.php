@extends('layout.app')
@section('title', 'Change Your Character Race')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change">
            <x-form.select name="race[]" text="Race" :data="$datas" :value="$value" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection