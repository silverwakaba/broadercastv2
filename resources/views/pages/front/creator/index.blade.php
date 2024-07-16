@extends('layout.app')
@section('title', 'Creator Discovery')
@section('content')
    <x-Adminlte.Content>
        <div class="row">
            <div class="col-md-4">
                <x-Adminlte.CardForm title="Search Parameter" button="Search">
                    <x-form.Input name="channelname" type="text" text="Channel Name" :value="request()->channelname" />
                    <x-form.Input name="profilename" type="text" text="Profile Name" :value="request()->profilename" />

                    <x-form.Input name="channelsubsrangefrom" type="number" text="Subs Range From" :value="request()->channelsubsrangefrom" col="6" placeholder="1" />
                    <x-form.Input name="channelsubsrangeto" type="number" text="Subs Range To" :value="request()->channelsubsrangeto" col="6" placeholder="1000" />
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