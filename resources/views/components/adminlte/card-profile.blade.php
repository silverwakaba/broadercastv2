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
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <strong>Content</strong>
                @if($profile->content)
                    <ul class="list-inline m-0">
                        @foreach($profile->content AS $content)
                            <li class="list-inline-item">{{ $content->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No focus content yet.</p>
                @endif
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
                    <p class="m-0">No gender representation yet.</p>
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
                    <p class="m-0">No main language yet.</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>Race</strong>
                @if($profile->race)
                    <ul class="list-inline m-0">
                        @foreach($profile->race AS $race)
                            <li class="list-inline-item">{{ $race->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="m-0">No character race yet.</p>
                @endif
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
                    <p class="m-0">No external link yet.</p>
                @endif
            </li>
            <li class="list-group-item">
                <strong>User Channel</strong>
                @if($channels)
                    <x-adminlte.card-channel :channels="$channels" />
                @else
                    <p class="m-0">No user channel yet.</p>
                @endif
            </li>
        </ul>
    </div>
</div>