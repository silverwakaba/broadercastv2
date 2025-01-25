@extends('layout.app')
@section('title', $profile->name)
@section('description', "Explore comprehensive profiles of $profile->name on vTual! You can access their biodata, video collections, ongoing livestreams and past livestream archive. Stay informed about $profile->name activity schedules and receive their latest updates.")
@section('image', $profile->avatar->path)
@section('content')
    <x-Adminlte.Content :title="$profile->name">
        <div class="row">
            <div class="col-xl-4">
                <x-Adminlte.CardProfile :profile="$profile" :links="$link" :channels="$tracker" />
            </div>
            <div class="col-xl-8">
                <x-Adminlte.CardForm title="Search" button="Search">
                    <x-Form.Select2n col="6" name="timezone" text="Timezone" :data="$timezone" :value="$timezone_value" grab="name" />
                    <x-Form.Select2n col="6" name="live_content" text="Live/Archive Content Sort By" :data="$sort" :value="$live_value" grab="name" />
                    <x-Form.Select2n col="6" name="schedule_content" text="Schedule Content Sort By" :data="$sort" :value="$schedule_value" grab="name" />
                    <x-Form.Select2n col="6" name="vod_content" text="Archive & VOD Content Sort By" :data="$sort" :value="$vod_value" grab="name" />
                    <x-form.input col="12" name="title" type="text" :value="request()->title" text="Stream Title" />
                </x-Adminlte.Card>
                <x-Adminlte.Card title="Live Feed">
                    <x-Adminlte.CardFeed col="3" :feeds="$liveFeed" />
                </x-Adminlte.Card>
                <x-Adminlte.Card title="Scheduled Feed">
                    <x-Adminlte.CardFeed col="3" :feeds="$scheduleFeed" />
                </x-Adminlte.Card>
                <x-Adminlte.Card title="Archive & VOD Feed">
                    <x-Adminlte.CardFeed col="3" :feeds="$archivodFeed" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection