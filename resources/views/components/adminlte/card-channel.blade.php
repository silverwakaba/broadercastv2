<div class="row row-cols-1 row-cols-lg-{{ $col }}">
    @foreach($channels->data AS $data)
        <div class="col text-truncate">
            <div class="card card-widget widget-user">
                @if($data->activity)
                    <div class="ribbon-wrapper">
                        <div class="ribbon bg-danger">
                            <span data-toggle="tooltip" data-placement="right" title="LIVE NOW">
                                <i class="fas fa-circle"></i>
                            </span>
                        </div>
                    </div>
                @endif
                <div class="widget-user-header" style="background: url('{{ $data->banner }}') center center;">
                    <h3 class="widget-user-username">
                        <span class="badge badge-dark" data-toggle="tooltip" data-placement="top" title="{{ $data->name }}">{{ $data->name }}</span>
                    </h3>
                    <h5 class="widget-user-desc">
                        <span class="badge badge-dark">{{ $data->link->name }} Channel</span>
                    </h5>
                </div>

                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="{{ $data->avatar }}" />
                </div>
                <div class="card-footer">
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col">
                            <div class="description-block">
                                <h5 class="description-header">{{ number_format($data->subscriber) }}</h5>
                                <span class="description-text">SUBSCRIBER</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="description-block">
                                <h5 class="description-header">
                                    @if(($data->concurrent == 0) && ($data->activity))
                                        <abbr data-toggle="tooltip" data-placement="top" title="The '0 concurrent' incident sometimes happens because we failed to retrieve the data correctly.">{{ number_format($data->concurrent) }} <i class="fas fa-info-circle text-warning"></i></abbr>
                                    @else
                                        {{ number_format($data->concurrent) }}
                                    @endif
                                </h5>
                                <span class="description-text">CONCURRENT</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="description-block">
                                <h5 class="description-header">{{ number_format($data->view) }}</h5>
                                <span class="description-text">TOTAL VIEW</span>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1">
                        @if($data->activity)
                            <div class="col">
                                <a href="{{ $data->activity->link }}" target="_blank">
                                    <div class="card m-0">
                                        <img src="{{ $data->activity->thumbnail }}" class="card-img-top" />
                                        <div class="card-body">
                                            <h5 class="text-truncate h5 m-0" data-toggle="tooltip" data-placement="top" title="{{ $data->activity->title }}">{{ $data->activity->title }}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="col mt-3 border">
                            <a href="{{ $data->channel->link }}" class="btn btn-sm btn-block text-light" target="_blank">VISIT CHANNEL <i class="fas fa-external-link-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>