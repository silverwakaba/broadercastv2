@if($mode == 'desktop')
    <li class="px-5.5">
        <a @class(["flex items-center justify-between py-1.5 transition-colors", "text-accent" => request()->routeIs($route), "text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" => !request()->routeIs($route)]) href="{{ route($route) }}">
            {{ $value }}
        </a>
    </li>
@elseif($mode == 'mobile')
    <!--  -->
    <li class="flex flex-wrap items-center gap-x-4">
        <a class="flex-grow gap-x-1 py-2 text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="{{ route($route) }}">
            {{ $value }}
        </a>
    </li>
@endif