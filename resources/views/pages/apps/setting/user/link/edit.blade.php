@extends('layout.app')
@section('title', 'Change Your External Link')
@section('content')
    <x-adminlte.content previous="apps.manager.link">
        <x-adminlte.cardform button="Change">
            <x-form.select2n name="service" text="Service" :data="$services" :value="$datas->base_link_id" />
            <x-form.input name="link" type="url" text="Link" :value="$datas->link" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection