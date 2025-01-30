@extends('layout.app')
@section('title', 'Content Setting')
@section('description', "Tailor your viewing experience by set up your content preferences and unlock a personalized feed that matches your interests here!")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Callout class="info">
            <h5>Notes before make change!</h5>
            <p><strong>About Cookies</strong></p>
            <ol>
                <li>The setting stores your preferences in a browser cookie.</li>
                <li>The settings and preferences cannot be personalized if your browser blocks external cookies.</li>
                <li>The settings will apply to the whole feed content, such as live, scheduled, archived and uploaded.</li>
                <li>The settings are not tied to an account, instead it will only be saved temporarily in the cache of your local browser and are valid for 30 days.</li>
                <li>The settings MAY NOT APPLY if you open the {{ config('app.name', 'vTual') }} on a new browser or within the next 30 days after the cache has expired or deleted.</li>
            </ol>
            <p><strong>About Sorting</strong></p>
            <ol>
                <li>Asc refers to ascending, where sorting will start from smallest to largest. For example from A - Z or from 1 - 9.</li>
                <li>Desc refers to descending, where sorting will start from largest to smallest. For example from Z - A or from 9 - 1.</li>
                <li>For example, if you want to see live content from newest to oldest, please set it to desc.</li>
                <li>Another example, if you want to see the content with number of live concurrent viewers from smallest to largest, please set it to asc.</li>
                <li>Language options refer to the language used by a content creator and are sensitive. For example, if you only enter Indonesian, then content from content creators who do not speak Indonesian will not be displayed.</li>
            </ol>
            <p><strong>Special Notes</strong></p>
            <ol>
                <li>Click on the "cross mark" icon and save the personalization to reset to default settings.</li>
            </ol>
        </x-Adminlte.Callout>
        <x-Adminlte.CardForm button="Personalize">
            <x-Form.Select2n name="timezone" text="Timezone" :data="$timezone" :value="$timezone_value" grab="name" />
            <x-Form.Select2n name="live_content" text="Sort Live/Archive Content" :data="$sort" :value="$live_value" grab="name" />
            <x-Form.Select2n name="schedule_content" text="Sort Schedule Content" :data="$sort" :value="$schedule_value" grab="name" />
            <x-Form.Select2n name="vod_content" text="Sort VOD Content" :data="$sort" :value="$vod_value" grab="name" />
            <x-Form.Select2n name="concurrent" text="Sort Concurrent View" :data="$sort" :value="$concurrent_value" grab="name" />
            <x-Form.Select2m name="language[]" text="Language" :data="$language" :value="$language_value" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection