@extends('layout.app')
@section('title', 'Change Biodata')
@section('content')
    <x-adminlte.content previous="apps.manager.index">
        <x-adminlte.cardform button="Change">
            <x-form.input name="name" type="text" text="Name" :value="$datas->name" />
            <x-form.input name="nickname" type="text" text="Nickname" :value="$datas->biodata->nickname" />
            <x-form.input name="dob" type="date" text="Date of Birth" :value="$datas->biodata->dob" />
            <x-form.input name="dod" type="date" text="Date of Debut" :value="$datas->biodata->dod" />
            <x-form.textarea name="biography" text="Biography" :value="$datas->biodata->biography" />
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection