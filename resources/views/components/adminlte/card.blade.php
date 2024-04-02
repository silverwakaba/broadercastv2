<div @class(["card", "card-outline card-$outline" => $outline, "card-outline-tabs" => $add])>
    @if($title || $add)
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" role="tablist">
                @if($title)
                    <li class="nav-item">
                        <h3 class="nav-link pt-2 h5">{{ $title }}</h3>
                    </li>
                @endif
                @if($add)
                    <li class="nav-item">
                        <a href="{{ route($add) }}" class="nav-link text-dark"><i class="fas fa-plus-square"></i> Add New</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>