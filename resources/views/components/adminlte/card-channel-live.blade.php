<div @class(["row row-cols-1", "row-cols-lg-$col" => $channels])>
    @if($channels)
        @foreach($channels AS $data)
            <div class="col">
                <div class="card card-widget">
                    <a href="{{ $data->activity->link }}" target="_blank">
                        <img src="{{ $data->activity->thumbnail }}" class="card-img-top">
                    </a>
                    <a href="{{ $data->channel->link }}" class="text-light" target="_blank">
                        <div class="card-header">
                            <div class="user-block">
                                <img class="img-fluid img-circle" src="{{ $data->avatar }}">
                                <div class="username">{{ $data->name }}</div>
                                <div class="description">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">{{ $data->activity->published }}</li>
                                        <li class="list-inline-item">{{ $data->activity->published_for_human }}</li>
                                        <li class="list-inline-item">{{ number_format($data->concurrent) }} viewers</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="card-body">
                        <h5 class="text-truncate h5 m-0" data-toggle="tooltip" data-placement="top" title="{{ $data->activity->title }}">{{ $data->activity->title }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col">
            <p class="lead text-center">It looks so quiet now...</p>
        </div>
    @endif
</div>