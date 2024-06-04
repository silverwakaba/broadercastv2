@extends('layout.app')
@section('title', $profile->name)
@section('content')
    <x-adminlte.content>
        <div class="row">
            <div class="col-md-3">
                <div class="card card-widget widget-user">
                    @if($profile->confirmed == true)
                        <div class="ribbon-wrapper">
                            <div class="ribbon bg-primary">
                                <span data-toggle="tooltip" data-placement="right" title="Verified Creator">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                        </div>
                    @endif
                    <div class="widget-user-header bg-secondary">
                        <h3 class="widget-user-username">{{ \Illuminate\Support\Str::limit($profile->name, 15, ' (...)') }}</h3>
                        <h5 class="widget-user-desc">{{ $profile->biodata->nickname ? \Illuminate\Support\Str::limit($profile->biodata->nickname, 15, ' (...)') : 'No nickname yet' }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ $profile->avatar->path }}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <strong>Content</strong>
                        @if($profile->content)
                            <ul class="list-inline">
                                @foreach($profile->content AS $content)
                                    <li class="list-inline-item">{{ $content->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No focus content yet.</p>
                        @endif
                        <strong>Gender</strong>
                        @if($profile->gender)
                            <ul class="list-inline">
                                @foreach($profile->gender AS $gender)
                                    <li class="list-inline-item">{{ $gender->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No gender representation yet.</p>
                        @endif
                        <strong>Language</strong>
                        @if($profile->language)
                            <ul class="list-inline">
                                @foreach($profile->language AS $language)
                                    <li class="list-inline-item">{{ $language->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No main language yet.</p>
                        @endif
                        <strong>Race</strong>
                        @if($profile->race)
                            <ul class="list-inline">
                                @foreach($profile->race AS $race)
                                    <li class="list-inline-item">{{ $race->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No character race yet.</p>
                        @endif
                        @if($profile->link)
                            <div class="border p-3 text-center">
                                <ul class="list-inline m-0">
                                    @foreach($profile->link AS $link)
                                        <li class="list-inline-item">
                                            <a href="{{ $link->link_pivot }}" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="{{ $link->name }}" target="_blank">
                                                <img height="25" width="25" src="{{ $link->logo }}" />
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                @if($tracker)
                    <x-adminlte.card title="Owned Channel">
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
                                <div class="widget-user-header bg-secondary">
                                    <h3 class="widget-user-username" data-toggle="tooltip" data-placement="top" title="{{ $trackers->name }}">{{ \Illuminate\Support\Str::limit($trackers->name, 15, ' (...)') }}</h3>
                                    <h5 class="widget-user-desc">{{ $trackers->link->name }} Channel</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="{{ $trackers->avatar }}" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-4 border-right">
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
                                        <div class="col-md-4 border-left">
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
            <div class="col-md-9">
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
                                <th width="20%">Platform</th>
                                <th width="25%">Date</th>
                                <th width="50%">Content</th>
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
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "datas.service.name",
                },
                {
                    data: "datas.published",
                },
                {
                    data: "datas.title",
                },
            ],
        });
    </script>
@endsection