@extends('layout.app')
@section('title', "Claim $profile->name Profile")
@section('content')
    <x-Adminlte.Content>
        <x-Adminlte.Card title="Guideline">
            <div class="lead">
                <p>In its operational and design, vTual features two distinct types of user accounts:</p>
                <ol>
                    <li><strong>"System Generated User"</strong> (or simply "SGU"), which pertains to users added to the system, done by the system itself.</li>
                    <li><strong>"Registered Generated User"</strong> (or simply "RGU"), which refers to users who independently register their accounts by themself.</li>
                </ol>
                <p>The features and functions of an SGU account are similar to those of a regular RGU account, offers the same experience. However, it is important to note that the access rights for these SGU accounts are significantly disabled before being claimed by the owner.</p>
                <p>Once claimed, the SGU account will transition into a manageable RGU account, allowing for further account management, administration and oversight.</p>
                <p>If you are the owner or a representative intending to manage this <strong><u>"{{ $profile->name }}"</u></strong> user account, please follow the guidelines provided below:</p>
                <ol>
                    <li>
                        <span>We will assume that you are the owner or representative of this <strong><u>"{{ $profile->name }}"</u></strong> user account that has full access to manage the following channels:</span>
                        <ul>
                            @foreach($tracker->data as $channel)
                                <li>{{ $channel->name }} (on <a href="{{ $channel->channel->link }}" target="_blank">{{ $channel->link->name }}</a>)</li>
                            @endforeach
                        </ul>
                        <span>If you are not, then please stop here!</span>
                    </li>
                    <li>To maintain security, account privacy and trust; <u>This process <em class="text-danger">does not implement or require</em> any form of authentication process</u>, such as <a href="https://en.wikipedia.org/wiki/OAuth" target="_blank">OAuth</a>. This means <u>we do not have any access to your account in any way possible</u>, both now and in the future.</li>
                    <li>Instead, in order to claim this <strong><u>"{{ $profile->name }}"</u></strong> user account, we need you to <u>add an unique detail</u> specifically in the <u>description section</u> of one of your channels.</li>
                    <li>This process <u>does not need to be carried out on all channels</u>, because if one of the channels successfully verifies, then this claim process is declared successful.</li>
                    <li>After that, <u>our crawler will try to match</u> the data. If a match is found, then you will have full access to manage this <strong><u>"{{ $profile->name }}"</u></strong> user account.</li>
                    <li>The verification <u>process will take place automatically</u> and the <u>results will appear immediately</u>. No need to wait for manual approval and further instruction regarding account access will be sent via email.</li>
                    <li>After the verification process is successful, <u>you are allowed to remove/delete the unique detail from your description section</u> because it is no longer needed.</li>
                    <li>To avoid the possibility of abuse, the <u>submission process can only be done once every hour</u>. Please use this feature very wisely.</li>
                    <li>If the verification attempt reaches the limit, <u>you have to wait until the number of attempts is reset</u> in the next period (every 1 hours, since the last time you tried to verify). <sup><a href="#">[?]</a></sup></li>
                    <li>
                        <span>Your unique detail is:</span>
                        <blockquote class="blockquote m-0">
                            <span>{{ $secret }}</span>
                        </blockquote>
                        <span>This unique detail is permanent and you can apply it to any of the channels related to this <strong><u>"{{ $profile->name }}"</u></strong> user account.</span>
                    </li>
                    <li>Only the official channel owner can perform this action. Any form of imitation and impersonation is prohibited.</li>
                    <li>This claim process can also be done manually by contacting us, if you prefer manual way or if there is a problem that requires human intervention.</li>
                </ol>
                <p>If you have further questions, please let us know. We thank you for your attention and cooperation.</p>
            </div>
        </x-Adminlte.Card>
        
        <x-Adminlte.Card title="Claim">
            <div class="lead">
                <ol>
                    <li>
                        <span>You can make a claim through one of the channels below:</span>
                        <ul>
                            @foreach($tracker->data as $channel)
                                <li>{{ $channel->name }} (on <a href="{{ $channel->channel->link }}" target="_blank">{{ $channel->link->name }}</a>) | <a href="{{ route('creator.claim.via', ['id' => $profile->identifier, 'ch' => $channel->identifier]) }}" target="_blank">Click here to make a claim through this channel</a></li>
                            @endforeach
                        </ul>
                        <span>Simply select one channel to be used as the basis for the final decision.</span>
                    </li>
                    <li>Further instructions will be explained on the next page.</li>
                    <li>Contact us if you need further assistance.</li>
                </ol>
            </div>
        </x-Adminlte.Card>
    </x-Adminlte.Content>
@endsection