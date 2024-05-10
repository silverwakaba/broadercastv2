@extends('layout.app')
@section('title', 'Change Your Focus Content')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change">
            <x-form.select2m name="content[]" text="Content" :data="$datas" :value="$value" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection