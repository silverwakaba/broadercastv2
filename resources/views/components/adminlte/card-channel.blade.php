<div @class(["scrolling-pagination" => isset($channels->links)])>
    <div @class(["row row-cols-1", "row-cols-lg-$col" => count($channels->data) >= 1])>
        @if(($channels) && (count($channels->data) >= 1))
            @foreach($channels->data AS $data)
                <div class="col text-truncate">
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header" style="background: url('{{ $data->banner }}') center center;">
                            <!-- Placeholder -->
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-5" src="{{ $data->avatar }}">
                        </div>
                        <div class="card-footer text-truncate">
                            <div class="description-block">
                                <h5 class="description-header">{{ $data->name }}</h5>
                                <span class="description-text">{{ $data->link->name }} Channel</span>
                            </div>
                            <div class="row row-cols-1 row-cols-md-3">
                                <div class="col">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ number_format($data->subscriber) }}</h5>
                                        <span class="description-text">SUBSCRIBER</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ number_format($data->content) }}</h5>
                                        <span class="description-text">CONTENT</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ number_format($data->view) }}</h5>
                                        <span class="description-text">TOTAL VIEW</span>
                                    </div>
                                </div>
                            </div>
                            <div @class(["row", "row-cols-1" => isset($data->profile->page) xor isset($data->channel->link), "row-cols-xl-2" => isset($data->profile->page) && isset($data->channel->link), "mt-3"])>
                                @if(isset($data->profile->page))
                                    <div class="col">
                                        <a href="{{ $data->profile->page }}" class="btn btn-sm btn-outline-light btn-block">PROFILE</a>
                                    </div>
                                @endif
                                @if(isset($data->channel->link))
                                    <div class="col">
                                        <a href="{{ $data->channel->link }}" class="btn btn-sm btn-outline-light btn-block" target="_blank">CHANNEL</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(isset($channels->links->next))
                <div class="href-pagination">
                    <a href="{{ $channels->links->next }}" class="scrolling-paging">Loading...</a>
                </div>
            @endif
        @else
            <div class="col my-4">
                <p class="lead text-center m-0">No channel were found...</p>
            </div>
        @endif
    </div>
</div>