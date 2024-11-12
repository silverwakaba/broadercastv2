@extends('layout.app')
@section('title', "Claim $profile->name Profile")
@section('content')
    <x-Adminlte.Content :previous="route('creator.claim', ['id' => $profile->identifier])">
        <x-Adminlte.CardForm title="Claim" button="Claim" captcha="1">
            @foreach($tracker->data as $channel)
                <x-Form.Input name="email" type="email" text="Email" placeholder="Enter your email for further instruction regarding account access. THIS IS NOT YOUR NEW EMAIL ACCESS." />
                <x-Form.Input name="unique" type="text" text="Unique Detail" :value="$secret" readonly />
                <x-Form.Input name="service" type="text" text="Service" :value="$channel->link->name" readonly />
                <x-Form.Input name="identifier" type="text" text="Identifier" :value="$channel->identifier" readonly />
                <x-Form.Input name="channel" type="text" text="Channel" :value="$channel->channel->link" readonly />
                <x-Form.Checkbox name="terms" value="1">I have read and understand this claim process</x-Form.Checkbox>
            @endforeach
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection