@extends('layout.app')
@section('title', 'Change Your External Link')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.CardForm button="Change">
            @if($protected)
                <x-Form.Input name="readonly" type="text" text="Link" :value="$datas->belongsToBaseLink->name" readonly />
                <x-Form.Select2n name="service" text="Service" :data="$services" :value="$datas->base_link_id" extclass="d-none" />
            @else
                <x-Form.Select2n name="service" text="Service" :data="$services" :value="$datas->base_link_id" />
            @endif
            <x-Form.Input name="link" type="url" text="Link" :value="$datas->link" />
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection