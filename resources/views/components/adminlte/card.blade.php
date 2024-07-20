<div @class(["card", "card-outline card-$outline" => $outline, "card-outline-tabs" => $add])>
    @if($title || $add || $tab)
        <div @class(["card-header p-0", "d-flex" => $tab])>
            <ul class="nav nav-tabs mr-auto">
                @if($title)
                    <li class="nav-item">
                        <h3 class="nav-link card-title h3 pt-2">{{ $title }}</h3>
                    </li>
                @endif
                @if($add)
                    <li class="nav-item">
                        <a href="{{ $add }}" class="nav-link text-dark"><i class="fas fa-plus-square"></i> Add New</a>
                    </li>
                @endif
            </ul>
            @if($tab)
                <ul class="nav nav-tabs float-right">
                    @foreach($tab as $key => $value)
                        <li class="nav-item">
                            <a href="#tab_{{ $key }}" @class(["nav-link", "text-light", "active" => $key == 0]) data-toggle="tab">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
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