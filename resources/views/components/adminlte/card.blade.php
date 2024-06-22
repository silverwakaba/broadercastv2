@props(['id'])
<div @class(["card", "card-outline card-$outline" => $outline, "card-outline-tabs" => $add])>
    @if($title || $add || $tab)
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
                @if($tab)
                    @foreach($tab as $key => $value)
                        <li class="nav-item">
                            <a href="#tab_{{ $key }}" @class(["nav-link", "text-light", "active" => $key == 0]) data-toggle="tab">{{ $value }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
        @if($tabContent)
            <div class="tab-content">
                {{ $tabContent }}
            </div>
        @endif
    </div>
</div>