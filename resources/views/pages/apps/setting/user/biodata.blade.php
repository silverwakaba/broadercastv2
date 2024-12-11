@extends('layout.app')
@section('title', 'Change Biodata')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.Callout class="info">
            <h5>Notes before submitting!</h5>
            <ol class="m-0">
                <li>You are allowed to fill in the data below as creatively as possible.</li>
                <li>For the sake of information accuracy, please fill in the data below correctly and responsibly.</li>
                <li>It is recommended to disguise personal data such as date of birth (e.g. Enter the correct date and month, but set the year to 1900 - "04/24/1900" for April 24th).</li>
                <li>The biography section partially supports <a class="text-light" href="https://www.markdownguide.org/cheat-sheet/" target="_blank">markdown</a>-based writing format. For security reasons, some functions such as images, tables, writing formats and few more may not be usable.</li>
                <li>For public links, you can change them yourself via the <a class="text-light" href="{{ route('apps.manager.handler') }}">handler</a>.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.CardForm button="Change">
            <x-Form.Input name="name" type="text" text="Name [this one]" :value="$datas->name" placeholder="Your stage or real name is fine..." />
            <x-Form.Textarea name="nickname" text="Nickname" :value="$datas->hasOneUserBiodata->nickname" placeholder="Have another name? Separate into new lines!" />
            <x-Form.Input name="dob" type="date" text="Date of Birth" :value="$datas->hasOneUserBiodata->dob" />
            <x-Form.Input name="dod" type="date" text="Date of Debut" :value="$datas->hasOneUserBiodata->dod" />
            <x-Form.Input name="dor" type="date" text="Date of Retirement (As content creator)" :value="$datas->hasOneUserBiodata->dor" />
            <x-Form.Textarea name="biography" text="Biography" :value="$datas->hasOneUserBiodata->biography" placeholder="Tell us about yourself..." />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection