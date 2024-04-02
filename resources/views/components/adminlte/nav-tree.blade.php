<li @class(["nav-item has-treeview", "menu-open" => request()->routeIs(explode(', ', $route[0]))])>
    {{ $slot}}
</li>