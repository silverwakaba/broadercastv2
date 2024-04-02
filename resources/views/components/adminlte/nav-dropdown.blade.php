<li @class(["nav-item dropdown", "active" => request()->routeIs($route)])>
    {{ $slot }}
</li>