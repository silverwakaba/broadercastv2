<a href="{{ $route ? route($route) : "#" }}" @class(["$mode" => $mode, "active" => request()->routeIs($route)])>
    @if($icon != null && $fa == null && $parent == null)
        <i class="nav-icon fas fa-circle"></i>
        <p>{{ $value }}</p>
    @elseif($icon != null && $fa != null && $parent == null)
        <i class="nav-icon {{ $fa }}"></i>
        <p>{{ $value }}</p>
    @elseif($icon != null && $fa != null && $parent != null)
        <i class="nav-icon {{ $fa }}"></i>
        <p>{{ $value }} <i class="right fas fa-angle-left"></i></p>
    @else
        @if(!$mode)
            <p>{{ $value }}</p>
        @else
            <span>{{ $value }}</span>
        @endif
    @endif
</a>