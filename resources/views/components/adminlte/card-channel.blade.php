<div class="row row-cols-1 row-cols-lg-{{ $col }}">
    @foreach($channels AS $data)
        <div class="col text-truncate">
            <div class="card card-widget widget-user">
                <div class="widget-user-header" style="background: url('{{ $data->banner }}') center center;">
                    <!--  -->
                </div>
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="{{ $data->avatar }}" />
                </div>
                <div class="card-footer text-truncate">
                    
                    <div class="description-block">
                        <h5 class="description-header">{{ $data->name }}</h5>
                        <span class="description-text">{{ $data->link->name }} Channel</span>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <div class="description-block">
                                <h5 class="description-header">{{ number_format($data->subscriber) }}</h5>
                                <span class="description-text">SUBSCRIBER</span>
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
                        <div class="col mt-3 border">
                            <a href="{{ $data->channel->link }}" class="btn btn-sm btn-block text-light" target="_blank">VISIT CHANNEL <i class="fas fa-external-link-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>