@extends('layout.app')
@section('title', 'Change Your Main Language')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change">
            <x-form.select2m name="language[]" text="Language" :data="$datas" :value="$value" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection