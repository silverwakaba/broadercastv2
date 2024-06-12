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
            <img class="profile-user-img img-fluid img-circle" src="{{ $profile->avatar->path }}" />
            <h3 class="profile-username" data-toggle="tooltip" data-placement="top" title="{{ $profile->name }}">{{ $profile->name_preview }}</h3>
            <p class="text-muted text-center">{{ $profile->title_temp }}</p>
        </div>
        <ul class="list-group">
            <li class="list-group-item text-center bg-secondary">
                <strong>Basic Details</strong>
            </li>
            <li class="list-group-item">
                <strong>Nickname</strong>
                <p class="m-0">{{ $profile->biodata->nickname }}</p>
            </li>
            <li class="list-group-item">
                <strong>Debut Date</strong>
                @if($profile->biodata->dod)
                    <p class="m-0">{{ $profile->biodata->dod }}</p>
                @else
                    <p class="m-0">Unknown</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>About</strong>
                @if($profile->biodata->biography)
                    {!! $profile->biodata->biography !!}
                @else
                    <p class="m-0">Nothing known about this creator</p>
                @endif
            </li>
            <li class="list-group-item text-center bg-secondary">
                <strong>Personal Details</strong>
            </li>
            <li class="list-group-item">
                <strong>Gender</strong>
                @if($profile->gender)
                    <ul class="list-inline m-0">
                        @foreach($profile->gender AS $gender)
                            <li class="list-inline-item">{{ $gender->name }}</li>
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
                            <li class="list-inline-item">{{ $content->name }}</li>
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
                            <li class="list-inline-item">{{ $language->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No main language</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Lore</strong>
                @if($profile->race)
                    <ul class="list-inline m-0">
                        @foreach($profile->race AS $race)
                            <li class="list-inline-item">{{ $race->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No character race</p>
                @endif
            </li>
            <li class="list-group-item text-center bg-secondary">
                <strong>Resource</strong>
            </li>
            <li class="list-group-item">
                <strong>External Link</strong>
                @if($links)
                    <ul class="list-inline text-center m-0">
                        @foreach($links AS $link)
                            <li class="list-inline-item">
                                <a href="{{ $link->link }}" class="btn btn-sm btn-link border" data-toggle="tooltip" data-placement="top" title="{{ $link->service->name }}" target="_blank">
                                    <img height="25" width="25" src="{{ $link->service->logo }}" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No external link</p>
                @endif
            </li>
            <li class="list-group-item">
                <p><strong>Channel</strong></p>
                @if($channels)
                    <x-Adminlte.CardChannel :channels="$channels" />
                @else
                    <p class="m-0">No channel</p>
                @endif
            </li>
        </ul>
    </div>
</div>