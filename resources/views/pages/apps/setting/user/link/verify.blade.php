@extends('layout.app')
@section('title', 'Verify ' . $datas->belongsToBaseLink->name . ' Link')
@section('content')
    <x-adminlte.content previous="apps.manager.link">
        <x-adminlte.card title="Instructions">
            <div class="lead">
                <p>Please read the guidelines and requirements regarding the process of verifying the {{ $datas->belongsToBaseLink->name }} link that you have added, so that it can be included in our future crawler distribution:</p>
                <ol>
                    <li>In order to maintain account security and privacy, this process <u>does not require</u> you to log in to your {{ $datas->belongsToBaseLink->name }} account. This means we do not have any access to your account in any way possible, both now and in the future.</li>
                    <li>Instead we need you to <u>add a small and unique detail to your profile</u>, specifically in the <u>description section</u>.</li>
                    <li>After that <u>our crawler will try to match</u> the data. If a match is found, then this {{ $datas->belongsToBaseLink->name }} link will <u>automatically be marked as verified</u> and will start to be <u>crawled on our timeline</u>.</li>
                    <li>The verification <u>process will take place automatically</u> and the <u>results will appear immediately</u>.</li>
                    <li>After the verification process is successful, <u>you are allowed to delete the unique detail</u> because it is no longer needed.</li>
                    <li>To avoid the possibility of abuse, the <u>submission process can only be done twice every hour</u>. Please use this feature wisely.</li>
                    <li>Your unique detail is <span class="badge badge-secondary">{{ $secret }}</span>. Please <u>keep this unique detail a secret</u> to avoid impersonation in the verification process.</li>
                    <li>The unique details above are valid for single use only.</li>
                </ol>
                <p>If you have further questions, please let us know. We thank you for your attention and cooperation.</p>
            </div>
        </x-adminlte.card>

        <x-adminlte.cardform title="Verify" button="Submit">
            
            <x-form.input name="unique" type="text" text="Unique Detail" :value="$secret" readonly />
            <x-form.input name="service" type="text" text="Service" :value="$datas->belongsToBaseLink->name" readonly />
            <x-form.input name="channel" type="text" text="Channel" :value="$datas->link" readonly />
            <x-form.checkbox name="terms" value="1">I have read and understand this validation process</x-form.checkbox>

        </x-adminlte.cardform>
    </x-adminlte.content>
@endsection