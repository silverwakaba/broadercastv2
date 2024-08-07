@extends('layout.app')
@section('title', 'Change Biodata')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.Callout class="info">
            <h5>Notes before submitting!</h5>
            <ol class="m-0">
                <li>You are allowed to fill in the data below as creatively as possible.</li>
                <li>For the sake of information accuracy, please fill in the data below correctly and responsibly.</li>
                <li>
                    <span>However, the "Name [this one]" column must be filled in using latin alphabet (the "ABC" one).</span>
                    <blockquote class="blockquote m-0">
                        <ul>
                            <li><u>"Kurokuma Wakaba"</u> instead of <u>"黒いくまわかば"</u></li>
                            <li><u>"Geom-eungom Wakaba"</u> instead of <u>"검은곰와카바"</u></li>
                            <li>etc</li>
                        </ul>
                    </blockquote>
                    <span>As the name you enter will be associated with your account links handler and our system currently can only process latin alphabet.</span>
                </li>
                <li>It is recommended to disguise personal data such as date of birth (e.g. Enter the correct date and month, but set the year to 1900).</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.CardForm button="Change">
            <x-Form.Input name="name" type="text" text="Name [this one]" :value="$datas->name" placeholder="Your stage or real name is fine..." />
            <x-Form.Textarea name="nickname" text="Nickname" :value="$datas->hasOneUserBiodata->nickname" placeholder="Have another name? Separate into new lines!" />
            <x-Form.Input name="dob" type="date" text="Date of Birth" :value="$datas->hasOneUserBiodata->dob" />
            <x-Form.Input name="dod" type="date" text="Date of Debut" :value="$datas->hasOneUserBiodata->dod" />
            <x-Form.Input name="dor" type="date" text="Date of Retirement" :value="$datas->hasOneUserBiodata->dor" />
            <x-Form.Textarea name="biography" text="Biography" :value="$datas->hasOneUserBiodata->biography" placeholder="Tell us about yourself..." />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection