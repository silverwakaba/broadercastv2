@if($mode == 'desktop')
    <li>
        <a @class(["group text-gray-900 dark:text-white relative inline-flex items-center gap-x-3 leading-10 px-3.5 xl:px-4.5 after:absolute after:top-[15px] after:left-0 after:bg-current-marker-dark after:transition-transform after:w-1.5 after:h-[9px] dark:after:bg-current-marker", "after:origin-left after:scale-x-100" => request()->routeIs($route), "after:origin-right hover:after:origin-left after:scale-x-0 hover:after:scale-x-100" => !request()->routeIs($route)]) href="{{ $route ? route($route) : '#' }}">
            {{ $value }}
        </a>
    </li>
@elseif($mode == 'mobile')
    <li class="flex flex-wrap items-center gap-x-4 border-b border-b-gray-200/50 dark:border-b-gray-200/10">
        <a class="flex-grow gap-x-1 py-4 leading-normal text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="{{ $route ? route($route) : '#' }}">
            {{ $value }}
        </a>
    </li>
@endif