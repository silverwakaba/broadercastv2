<div class="row row-cols-3">
</div>

@foreach($channels AS $data)
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
                <span class="badge badge-dark text-light" data-toggle="tooltip" data-placement="top" title="{{ $data->name }}">{{ $data->name_preview }}</span>
            </h3>
            <h5 class="widget-user-desc">
                <span class="badge badge-dark text-light">{{ $data->link->name }} Channel</span>
            </h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ $data->avatar }}" alt="User Avatar">
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-4">
                    <div class="description-block">
                        <h5 class="description-header">{{ number_format($data->subscriber) }}</h5>
                        <span class="description-text">SUBSCRIBER</span>
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="description-block">
                        <h5 class="description-header">{{ number_format($data->view) }}</h5>
                        <span class="description-text">TOTAL VIEW</span>
                    </div>
                </div>
                @if($data->activity)
                    <div class="col-12 mt-3">
                        <a href="{{ $data->activity->link }}" target="_blank">
                            <div class="card m-0">
                                <img src="{{ $data->activity->thumbnail }}" class="card-img-top" />
                                <div class="card-body">
                                    <h5 class="card-header text-truncate h5" data-toggle="tooltip" data-placement="top" title="{{ $data->activity->title }}">{{ $data->activity->title }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="col-12 border mt-3">
                    <a href="{{ $data->channel->link }}" class="btn btn-sm btn-block text-light" target="_blank">VISIT CHANNEL <i class="fas fa-external-link-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
@endforeach