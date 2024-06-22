<div @class(["scrolling-pagination" => isset($feeds->links) ])>
    <div @class(["row row-cols-1", "row-cols-lg-2" => count($feeds->data) == 2, "row-cols-lg-$col" => count($feeds->data) >= 3])>
        @if(($feeds) && (count($feeds->data) >= 1))
            @foreach($feeds->data AS $data)
                <div class="col">
                    <div class="card card-widget">
                        <a href="{{ $data->link }}" target="_blank">
                            <img src="{{ $data->thumbnail }}" class="card-img-top" />
                            <div class="card-img-overlay text-right">
                                @if($data->duration == null)
                                    <span class="badge badge-danger">{{ number_format($data->concurrent) }} watching</span>
                                @else
                                    <span class="badge badge-dark">{{ $data->duration }}</span>
                                @endif
                            </div>
                        </a>
                        <a href="{{ $data->channel->link }}" class="text-light" target="_blank">
                            <div class="card-header">
                                <div class="user-block">
                                    <img class="img-fluid img-circle" src="{{ $data->profile->avatar }}" />
                                    <div class="username">{{ $data->profile->name }}</div>
                                    <div class="description">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">{{ $data->timestamp }}</li>
                                            <li class="list-inline-item">{{ $data->timestamp_for_human }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="card-body">
                            <h5 class="text-truncate h5 m-0" title="{{ $data->title }}">{{ $data->title }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(isset($feeds->links) && (count($feeds->data) >= 1))
                <div class="scrolling-paging">
                    <a href="{{ $feeds->links->next }}">Loading...</a>
                </div>
            @endif
        @else
            <div class="col my-4">
                <p class="lead text-center m-0">It looks so quiet now...</p>
            </div>
        @endif
    </div>
</div>