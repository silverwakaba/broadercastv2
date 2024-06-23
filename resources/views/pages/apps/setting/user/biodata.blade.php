@extends('layout.app')
@section('title', 'Change Biodata')
@section('content')
    <x-Adminlte.Content previous="apps.manager.index">
        <x-Adminlte.Callout class="info">
            <h5>Notes before submitting!</h5>
            <ol class="m-0">
                <li>For the sake of information accuracy, please fill in the data below correctly and responsibly.</li>
                <li>It is recommended to disguise personal data such as date of birth (for example enter the year as 1900).</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.CardForm button="Change">
            <x-Form.Input name="name" type="text" text="Name" :value="$datas->name" placeholder="Your stage or real name is fine..." />
            <x-Form.Textarea name="nickname" text="Nickname" :value="$datas->hasOneUserBiodata->nickname" placeholder="Have another name? Separate into new lines!" />
            <x-Form.Input name="dob" type="date" text="Date of Birth" :value="$datas->hasOneUserBiodata->dob" />
            <x-Form.Input name="dod" type="date" text="Date of Debut" :value="$datas->hasOneUserBiodata->dod" />
            <x-Form.Textarea name="biography" text="Biography" :value="$datas->hasOneUserBiodata->biography" placeholder="Tell us about yourself..." />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection