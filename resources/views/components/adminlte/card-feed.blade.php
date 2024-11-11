<div @class(["scrolling-pagination" => isset($feeds->links)])>
    <div @class(["row row-cols-1", "row-cols-lg-$col" => count($feeds->data) >= 1])>
        @if(($feeds) && (count($feeds->data) >= 1))
            @foreach($feeds->data AS $data)
                <div class="col">
                    <div class="card card-widget">
                        <div class="tube-post">
                            <a href="{{ $data->link }}" class="embed-responsive embed-responsive-16by9" target="_blank">
                                <img src="{{ $data->thumbnail }}" title="{{ $data->title }}" class="card-img-top embed-responsive-item">
                                @if(($data->base_status_id == 8))
                                    <span class="vid-view bg-danger text-white p-1">{{ number_format($data->concurrent) }}</span>
                                @endif
                                @if(($data->base_status_id != 6) || ($data->base_status_id != 7))
                                    <span class="vid-time bg-secondary text-white p-1">{{ $data->duration }}</span>
                                @endif
                            </a>
                        </div>
                        <a href="{{ $data->user->page }}" class="text-light" title="{{ $data->profile->name }}">
                            <div class="card-header">
                                <div class="user-block">
                                    <img class="img-fluid img-circle" src="{{ $data->profile->avatar }}">
                                    <div class="username">{{ $data->profile->name }}</div>
                                    <div class="description">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">{{ $data->timestamp_for_human }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ $data->link }}" target="_blank" class="text-light">
                            <div class="card-body">
                                <h5 class="text-truncate h5 m-0" title="{{ $data->title }}">{{ $data->title }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            @if(isset($feeds->links->next))
                <div class="href-pagination">
                    <a href="{{ $feeds->links->next }}" class="scrolling-paging">Loading...</a>
                </div>
            @endif
        @else
            <div class="col my-4">
                <p class="lead text-center m-0">It looks so quiet now...</p>
            </div>
        @endif
    </div>
</div>