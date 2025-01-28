<div @class(["scrolling-pagination" => count($rels->data) >= 1])>
    <div @class(["row row-cols-1", "row-cols-lg-$col" => count($rels->data) >= 1])>
        @if(isset($rels) && ($rels) && (count($rels->data) >= 1))
            @foreach($rels->data AS $data)
                <div class="col">
                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $data->avatar->path }}">
                                <h3 class="profile-username" data-toggle="tooltip" data-placement="top" title="{{ $data->name }}">{{ $data->name_preview }}</h3>
                                <div class="row row-cols-1 row-cols-xl-2 mt-3">
                                    <div class="col">
                                        <a href="{{ $data->page }}" class="btn btn-sm btn-outline-light btn-block" target="_blank">PROFILE</a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ $data->rels }}" class="btn btn-sm btn-danger btn-block" data-toggle="tooltip" data-placement="top" title="Stop showing their activity from your timeline">UNFOLLOW</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if(isset($rels->links->next))
                <div class="href-pagination">
                    <a href="{{ $rels->links->next }}" rel="nofollow" class="scrolling-paging">Loading...</a>
                </div>
            @endif
        @else
            <div class="col my-4">
                <p class="lead text-center m-0">It looks so quiet now...</p>
            </div>
        @endif
    </div>
</div>