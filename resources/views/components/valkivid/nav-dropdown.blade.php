@if($mode == 'desktop')
    <li class="relative [&>.sub-menu]:hover:visible [&>.sub-menu]:hover:animate-popper-pop-in [&>.sub-menu]:hover:opacity-100">
        <a @class(["group text-gray-900 dark:text-white relative inline-flex items-center gap-x-3 leading-10 px-3.5 xl:px-4.5 after:absolute after:top-[15px] after:left-0 after:bg-current-marker-dark after:transition-transform after:w-1.5 after:h-[9px] dark:after:bg-current-marker", "after:origin-left after:scale-x-100" => request()->routeIs($route), "after:origin-right hover:after:origin-left after:scale-x-0 hover:after:scale-x-100" => !request()->routeIs($route)]) href="#">
            {{ $value }}
            <svg role="img" class="h-1.5 w-1.5 fill-gray-500 group-hover:fill-accent">
                <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
            </svg>
        </a>
        <ul class="sub-menu invisible absolute z-20 flex w-40 flex-col bg-white dark:bg-gray-700 py-2.5 text-sm font-bold opacity-0 shadow-2xl transition-all">
            {{ $slot }}
        </ul>
    </li>
@elseif($mode == 'mobile')
    <li class="flex flex-wrap items-center gap-x-4 border-b border-b-gray-200/50 dark:border-b-gray-200/10">
        <a class="flex-grow gap-x-1 py-4 leading-normal text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="#">
            {{ $value }}
        </a>
        <button class="js-mobile-submenu-toggle ml-auto inline-flex h-7 w-7 items-center justify-center transition-transform">
            <svg role="img" class="sub-menu-toggle h-1.5 w-1.5 fill-accent">
                <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
            </svg>
        </button>
        <ul class="flex max-h-0 w-full flex-col overflow-hidden pl-4 text-sm transition-all duration-300 [&>li:last-child]:pb-4">
            {{ $slot }}
        </ul>
    </li>
@endif