@extends('layout.app')
@section('title', 'Creator Discovery')
@section('description', "Unlock a treasure trove of entertainment! Explore our extensive library featuring your favorite content creators and discover new talents you will love by dive in and find your next obsession today!")
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-md-4">
                <x-Adminlte.CardForm title="Search Parameter" button="Search">
                    <x-form.Input name="channelname" type="text" text="Channel Name" :value="request()->channelname" />
                    <x-form.Input name="profilename" type="text" text="Profile Name" :value="request()->profilename" />
                    <x-form.Input name="channelsubsrangefrom" type="number" text="Subs Range From" :value="request()->channelsubsrangefrom" col="6" placeholder="1" />
                    <x-form.Input name="channelsubsrangeto" type="number" text="Subs Range To" :value="request()->channelsubsrangeto" col="6" placeholder="1000" />
                    <x-Form.Select2m name="affiliation[]" text="Affiliation" :data="$affiliation" :value="(array) request()->affiliation" />
                    <x-Form.Select2m name="content[]" text="Content" :data="$content" :value="(array) request()->content" />
                    <x-Form.Select2m name="gender[]" text="Gender" :data="$gender" :value="(array) request()->gender" />
                    <x-Form.Select2m name="language[]" text="Language" :data="$language" :value="(array) request()->language" />
                    <x-Form.Select2m name="persona[]" text="Persona" :data="$persona" :value="(array) request()->persona" />
                    <x-Form.Select2n name="sorttype" text="Sort Type" :data="$sortType" :value="request()->sorttype ? request()->sorttype : 2" />
                    <x-Form.Select2n name="sortby" text="Sort By" :data="$sortBy" :value="request()->sortby ? request()->sortby : 'time'" />
                </x-Adminlte.CardForm>
            </div>
            <div class="col-md-8">
                <x-Adminlte.Card title="Creator">
                    <x-Adminlte.CardChannel col="2" :channels="$datas" />
                </x-Adminlte.Card>
            </div>
        </div>
    </x-Adminlte.Content>
@endsection