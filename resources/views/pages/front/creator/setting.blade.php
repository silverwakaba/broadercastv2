@extends('layout.app')
@section('title', 'Content Setting')
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Callout class="info">
            <h5>Notes before make change!</h5>
            <ol class="m-0">
                <li>The settings below will only apply to dynamic data, such as video feeds.</li>
                <li>The settings below are not tied to an account, instead it will only be saved in the local browser and are valid for one month.</li>
                <li>The settings below MAY NOT APPLY if you open the {{ config('app.name', 'Broadercast') }} on a new browser or within the next month.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.CardForm button="Personalize">
            <x-Form.Select2n name="timezone" text="Timezone" :data="$timezone" :value="$timezone_value" grab="name" />
            <x-Form.Select2n name="live_content" text="Live/Archive Content Sort By" :data="$sort" :value="$live_value" grab="name" />
            <x-Form.Select2n name="schedule_content" text="Schedule Content Sort By" :data="$sort" :value="$schedule_value" grab="name" />
            <x-Form.Select2n name="vod_content" text="VOD Content Sort By" :data="$sort" :value="$vod_value" grab="name" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection