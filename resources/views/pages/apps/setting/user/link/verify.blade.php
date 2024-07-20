@extends('layout.app')
@section('title', 'Verify ' . $datas->belongsToBaseLink->name . ' Link')
@section('content')
    <x-Adminlte.Content :previous="$backURI">
        <x-Adminlte.Card title="Guideline">
            <div class="lead">
                <p>Please read the guidelines and requirements regarding the process of verifying the {{ $datas->belongsToBaseLink->name }} link that you have added, so that it can be included in our future crawler distribution:</p>
                <ol>
                    <li>To maintain security, account privacy and trust; <u>This process does not require any form of authentication process</u> between {{ $datas->belongsToBaseLink->name }} and {{ config('app.name') }}. This means we do not have any access to your account in any way possible, both now and in the future.</li>
                    <li>Instead we need you to <u>add an unique detail</u>, specifically in the <u>description section</u> of your channel.</li>
                    <li>After that, <u>our crawler will try to match</u> the data. If a match is found, then your {{ $datas->belongsToBaseLink->name }} channel will <u>automatically be marked as verified</u> and will start to be <u>crawled on our timeline</u>.</li>
                    <li>The verification <u>process will take place automatically</u> and the <u>results will appear immediately</u>.</li>
                    <li>After the verification process is successful, <u>you are allowed to delete the unique detail</u> because it is no longer needed.</li>
                    <li>
                        <span>The link structure you enter should be formatted like one of these:</span>
                        <ul>
                            @foreach($structure AS $link)
                                <li><span class="badge badge-secondary">{{ $link }}</span></li>
                            @endforeach
                        </ul>
                        <span>Please only use and submit one of the above formats.</span>
                    </li>
                    <li>If the link structure doesn't match as in the example, you can still <u><a href="{{ route('apps.manager.link.edit', ['did' => request()->did]) }}">make a changes</a></u> before submitting.</li>
                    <li>To avoid the possibility of abuse, the <u>submission process can only be done twice every hour</u>. Please use this feature wisely.</li>
                    <li>If the verification attempt reaches the limit, <u>you have to wait until the number of attempts is reset</u> in the next period (every 1 hours, since the last time you tried to verify). <sup><a href="#">[?]</a></sup></li>
                    <li>
                        <span>Your unique detail is:</span>
                        <blockquote class="blockquote m-0">
                            <span>{{ $secret }}</span>
                        </blockquote>
                        <span>If you feel you cannot complete the verification immediately, please <u>check the code above regularly</u> as the code changes every day.</span>
                    </li>
                </ol>
                <p>If you have further questions, please let us know. We thank you for your attention and cooperation.</p>
            </div>
        </x-Adminlte.Card>
        <x-Adminlte.CardForm title="Verify" button="Submit">  
            <x-Form.Input name="unique" type="text" text="Unique Detail" :value="$secret" readonly />
            <x-Form.Input name="service" type="text" text="Service" :value="$datas->belongsToBaseLink->name" readonly />
            <x-Form.Input name="channel" type="text" text="Channel" :value="$datas->link" readonly />
            <x-Form.Checkbox name="terms" value="1">I have read and understand this validation process</x-Form.Checkbox>
        </x-Adminlte.CardForm>
    </x-Adminlte.Content>
@endsection