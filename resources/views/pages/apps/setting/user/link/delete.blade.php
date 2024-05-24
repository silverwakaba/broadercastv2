@extends('layout.app')
@section('title', 'Delete ' . $datas->belongsToBaseLink->name . ' Tracker')
@section('content')
    <x-adminlte.content previous="apps.manager.link">
        <x-adminlte.card title="Guideline">
            <div class="lead">
                <p>Please read the guidelines and requirements regarding the process of deleting the {{ $datas->belongsToBaseLink->name }} tracker that you have added, so that it can be excluded in our future crawler distribution:</p>
                <ol>
                    <li>This action will remove the {{ $datas->belongsToBaseLink->name }} channel <u>"{{ $datas->hasOneUserLinkTracker->name }}"</u> link and tracker from your account.</li>
                    <li>This action will also delete all content that we have crawled from your account.</li>
                    <li>In the future, you or someone else can add a link to this {{ $datas->belongsToBaseLink->name }} channel again through the usual verification procedure.</li>
                </ol>
                <p>If you have further questions, please let us know. We thank you for your attention and cooperation.</p>
            </div>
        </x-adminlte.card>
        <x-adminlte.cardform title="Verify" button="Submit">  
            <x-form.input name="service" type="text" text="Service" :value="$datas->belongsToBaseLink->name" readonly />
            <x-form.input name="channel" type="text" text="Channel" :value="$datas->hasOneUserLinkTracker->name" readonly />
            <x-form.checkbox name="terms" value="1">I have read and understand this removal process</x-form.checkbox>
        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection