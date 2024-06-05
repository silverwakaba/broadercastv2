@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-adminlte.content>
        <div class="row">
            <div class="col-lg-4">
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
                            <!-- External Link -->
                            <li class="list-group-item">
                                <strong>External Link</strong>
                                @if($link)
                                    <ul class="list-inline text-center m-0">
                                        @foreach($link AS $links)
                                            <li class="list-inline-item">
                                                <a href="{{ $links->link }}" class="btn btn-sm btn-link" data-toggle="tooltip" data-placement="top" title="{{ $links->service->name }}" target="_blank">
                                                    <img height="25" width="25" src="{{ $links->service->logo }}" />
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="m-0">No external link yet.</p>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                @if($tracker)
                    <x-adminlte.card>
                        @foreach($tracker AS $trackers)
                            <div class="card card-widget widget-user">
                                @if($trackers->activity)
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-danger">
                                            <span data-toggle="tooltip" data-placement="right" title="LIVE NOW">
                                                <i class="fas fa-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="widget-user-header" style="background: url('{{ $trackers->banner }}') center center;">
                                    <h3 class="widget-user-username">
                                        <span class="badge badge-dark text-light" data-toggle="tooltip" data-placement="top" title="{{ $trackers->name }}">{{ $trackers->name_preview }}</span>
                                    </h3>
                                    <h5 class="widget-user-desc">
                                        <span class="badge badge-dark text-light">{{ $trackers->link->name }} Channel</span>
                                    </h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ $trackers->avatar }}" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ number_format($trackers->subscriber) }}</h5>
                                                <span class="description-text">SUBSCRIBER</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="description-block">
                                                <h5 class="description-header">
                                                    @if(($trackers->concurrent == 0) && ($trackers->activity))
                                                        <abbr data-toggle="tooltip" data-placement="top" title="The '0 concurrent' incident sometimes happens because we failed to retrieve the data. Sorry for this.">{{ number_format($trackers->concurrent) }} <i class="fas fa-info-circle text-warning"></i></abbr>
                                                    @else
                                                        {{ number_format($trackers->concurrent) }}
                                                    @endif
                                                </h5>
                                                <span class="description-text">CONCURRENT</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{ number_format($trackers->view) }}</h5>
                                                <span class="description-text">TOTAL VIEW</span>
                                            </div>
                                        </div>
                                        @if($trackers->activity)
                                            <div class="col-12 mt-3">
                                                <a href="{{ $trackers->activity->link }}" target="_blank">
                                                    <div class="card m-0">
                                                        <img src="{{ $trackers->activity->thumbnail }}" class="card-img-top" />
                                                        <div class="card-body">
                                                            <h5 class="card-header text-dark text-truncate h5" data-toggle="tooltip" data-placement="top" title="{{ $trackers->activity->title }}">{{ $trackers->activity->title }}</h5>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="col-12 border mt-3">
                                            <a href="{{ $trackers->channel->link }}" class="btn btn-sm btn-block" target="_blank">VISIT CHANNEL <i class="fas fa-external-link-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </x-adminlte.card>
                @endif
            </div>
            <div class="col-lg-8">
                <x-adminlte.card title="About">
                    @if($profile->biodata->biography)
                        {!! $profile->biodata->biography !!}
                    @else
                        <p>Nothing known about this creator yet.</p>
                    @endif
                </x-adminlte.card>
                <x-adminlte.card title="Archive">
                    <x-adminlte.table ids="feedTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="95%">Content</th>
                            </tr>
                        </thead>
                    </x-adminlte.table>
                </x-adminlte.card>
            </div>
        </div>
    </x-adminlte.content>

    <script type="module">
        $("#feedTable").DataTable({
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url()->current() }}",
            columns: [
                {
                    bSearchable: false,
                    class: "text-center",
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "title",
                    bSearchable: true,
                    render: function(data, type, row){
                        return `
                            <a href="${ row['link'] }" class="text-dark" target="_blank">
                                <div class="attachment-block clearfix m-0">
                                    <img class="attachment-img" src="${ row['thumbnail'] }" />
                                    <div class="attachment-pushed">
                                        <div class="attachment-text">${ row['service']['name'] } | ${ row['published'] }</div>
                                        <h4 class="attachment-heading">${ row['title'] }</h4>
                                    </div>
                                </div>
                            </a>
                        `;
                    },
                },
            ],
        });
    </script>
@endsection