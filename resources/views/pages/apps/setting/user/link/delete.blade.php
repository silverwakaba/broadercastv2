@extends('layout.app')
@section('title', 'Delete ' . $datas->belongsToBaseLink->name . ' Tracker')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.Card title="Guideline">
            <div class="lead">
                <p>Please read the guidelines and requirements regarding the process of deleting the {{ $datas->belongsToBaseLink->name }} tracker that you have added, so that it can be removed in our future crawler distribution:</p>
                <ol>
                    <li>This action will remove the {{ $datas->belongsToBaseLink->name }} channel "<u>{{ $datas->hasOneUserLinkTracker->name }}</u>" tracker from your account.</li>
                    <li>This action will also delete all of the content that we have crawled from your account.</li>
                    <li>In the future, you or someone else can add a link to this {{ $datas->belongsToBaseLink->name }} channel again through the usual verification procedure.</li>
                    <li>Once confirmed, this process is irreversible.</li>
                </ol>
                <p>If you have further questions, please let us know. We thank you for your attention and cooperation.</p>
            </div>
        </x-Adminlte.Card>
        <x-Adminlte.CardForm title="Confirm" button="Confirm">
            <x-Form.Input name="service" type="text" text="Service" :value="$datas->belongsToBaseLink->name" readonly />
            <x-Form.Input name="channel" type="text" text="Channel" :value="$datas->hasOneUserLinkTracker->name" readonly />
            <x-Form.Input name="identifier" type="text" text="Identifier" :value="$datas->hasOneUserLinkTracker->identifier" readonly />
            <x-Form.Input name="retype" type="text" text="Retype Identifier" placeholder="Retype identifier '{{ $datas->hasOneUserLinkTracker->identifier }}' above to confirm" />
            <x-Form.Checkbox name="terms" value="1">I have read and understand this removal process</x-Form.Checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection