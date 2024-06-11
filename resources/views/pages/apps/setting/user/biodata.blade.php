@extends('layout.app')
@section('title', 'Change Biodata')
@section('content')
    <x-Adminlte.Content previous="apps.manager.index">
        <x-Adminlte.CardForm button="Change">
            <x-Form.Input name="name" type="text" text="Name" :value="$datas->name" />
            <x-Form.Input name="nickname" type="text" text="Nickname" :value="$datas->hasOneUserBiodata->nickname" />
            <x-Form.Input name="dob" type="date" text="Date of Birth" :value="$datas->hasOneUserBiodata->dob" />
            <x-Form.Input name="dod" type="date" text="Date of Debut" :value="$datas->hasOneUserBiodata->dod" />
            <x-Form.Textarea name="biography" text="Biography" :value="$datas->hasOneUserBiodata->biography" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection