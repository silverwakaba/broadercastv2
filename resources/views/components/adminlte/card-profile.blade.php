<div class="card">
    @if($profile->confirmed == true)
        <div class="ribbon-wrapper">
            <div class="ribbon bg-primary">
                <span data-toggle="tooltip" data-placement="right" title="Verified Creator">
                    <i class="fas fa-check-circle"></i>
                </span>
            </div>
        </div>
    @endif
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ $profile->avatar->path }}">
            <h3 class="profile-username" data-toggle="tooltip" data-placement="top" title="{{ $profile->name }}">{{ $profile->name_preview }}</h3>
            <p class="text-muted text-center">{{ $profile->title_temp }}</p>
            @auth
                <p class="text-center">
                    @if((isset($profile->followed->followed)) && ($profile->followed->followed == true))
                        <a href="{{ route('creator.rels', ['id' => $profile->identifier]) }}" class="btn btn-block btn-danger" data-toggle="tooltip" data-placement="top" title="Stop showing their activity from your timeline">Unfollow</a>
                    @else
                        <a href="{{ route('creator.rels', ['id' => $profile->identifier]) }}" class="btn btn-block btn-success" data-toggle="tooltip" data-placement="top" title="Start showing their activity to your timeline">Follow</a>
                    @endif
                </p>
            @endauth
        </div>
        <ul class="list-group">
            <li class="list-group-item text-center bg-secondary">
                <strong>Basic Details</strong>
            </li>
            <li class="list-group-item">
                <strong>Nickname</strong>
                @if($profile->biodata->nickname)
                    <ul class="list-inline m-0">
                        @foreach($profile->biodata->nickname AS $nickname)
                            <li class="list-inline-item">{{ $nickname }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No nickname yet</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Debut Date</strong>
                @if($profile->biodata->dod)
                    <p class="m-0">{{ $profile->biodata->dod }}</p>
                @else
                    <p class="m-0">Unknown</p>
                @endif
            </li>
            @if($profile->biodata->dor)
                <li class="list-group-item">
                    <strong>Retirement Date</strong>
                    <p class="m-0">{{ $profile->biodata->dor }}</p>
                </li>
            @endif
            <li class="list-group-item">
                <strong>About</strong>
                @if($profile->biodata->biography)
                    <div>{!! $profile->biodata->biography !!}</div>
                @else
                    <p class="m-0">Nothing known about this creator</p>
                @endif
            </li>
            <li class="list-group-item text-center bg-secondary">
                <strong>Personal Details</strong>
            </li>
            <li class="list-group-item">
                <strong>Affiliation <sup>[<a href="https://help.silverspoon.me/docs/vtual/app/manager/affiliation#limitation" target="_blank">?</a>]</sup></strong>
                @if($profile->affiliation)
                    <ul class="list-inline m-0">
                        @foreach($profile->affiliation AS $affiliation)
                            <li class="list-inline-item"><u><a href="{{ route('creator.index', ['affiliation[]' => $affiliation->id]) }}" class="text-light">{{ $affiliation->name }}</a></u></li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No affiliation found</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Gender</strong>
                @if($profile->gender)
                    <ul class="list-inline m-0">
                        @foreach($profile->gender AS $gender)
                            <li class="list-inline-item"><u><a href="{{ route('creator.index', ['gender[]' => $gender->id]) }}" class="text-light">{{ $gender->name }}</a></u></li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No gender representation</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Birthday</strong>
                @if($profile->biodata->dob)
                    <p class="m-0">{{ $profile->biodata->dob }}</p>
                @else
                    <p class="m-0">Unknown</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Content</strong>
                @if($profile->content)
                    <ul class="list-inline m-0">
                        @foreach($profile->content AS $content)
                            <li class="list-inline-item"><u><a href="{{ route('creator.index', ['content[]' => $content->id]) }}" class="text-light">{{ $content->name }}</a></u></li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No focus content</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Language</strong>
                @if($profile->language)
                    <ul class="list-inline m-0">
                        @foreach($profile->language AS $language)
                            <li class="list-inline-item"><u><a href="{{ route('creator.index', ['language[]' => $language->id]) }}" class="text-light">{{ $language->name }}</a></u></li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No main language</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Persona</strong>
                @if($profile->race)
                    <ul class="list-inline m-0">
                        @foreach($profile->race AS $race)
                            <li class="list-inline-item"><u><a href="{{ route('creator.index', ['persona[]' => $race->id]) }}" class="text-light">{{ $race->name }}</a></u></li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No character persona</p>
                @endif
            </li>
            <li class="list-group-item text-center bg-secondary">
                <strong>Resource</strong>
            </li>
            <li class="list-group-item">
                @if($links)
                    <div class="text-center">
                        <strong>External Link</strong>
                        <ul class="list-inline m-0 my-3">
                            @foreach($links AS $link)
                                <li class="list-inline-item bg-white">
                                    <a href="{{ $link->link }}" class="btn btn-sm btn-link border p-2" data-toggle="tooltip" data-placement="top" title="{{ $link->service->name }}" target="_blank">
                                        <img height="25" width="25" src="{{ $link->service->logo }}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <strong>External Link</strong>
                    <p class="m-0">No external link</p>
                @endif
            </li>
            <li class="list-group-item">
                @if($channels)
                    <strong class="text-center"><p>Channel</p></strong>
                    <x-Adminlte.CardChannel :channels="$channels" />
                @else
                    <strong>Channel</strong>
                    <p class="m-0">No channel</p>
                @endif
            </li>
        </ul>
    </div>
</div>