<div class="header-wrapper text-white">
    <header id="site-header" class="text-white">
        <!-- Navbar Desktop -->
        <div class="max-w-[1360px] mx-auto px-5">
            <nav class="flex min-h-[64px] items-center gap-x-6 lg:gap-x-11 py-1 lg:min-h-[90px] lg:py-4">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="_str1-index.html">
                        <img class="w-20 h-10 hidden dark:block" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-light-50-transparent.png" alt="vTual Logo Light">
                        <img class="w-20 h-10 block dark:hidden" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-dark-50-transparent.png" alt="vTual Logo Dark">
                    </a>
                </div>
                <!-- Navigation (Desktop) -->
                <ul class="hidden lg:gap-x-0 xl:gap-x-6 text-sm font-bold lg:flex">
                    <!-- Home, inactive -->
                    <li class="">
                        <a class="group text-gray-900 dark:text-white relative inline-flex items-center gap-x-3 leading-10 px-3.5 xl:px-4.5 after:absolute after:top-[15px] after:left-0 after:bg-current-marker-dark after:transition-transform after:w-1.5 after:h-[9px] dark:after:bg-current-marker after:origin-right hover:after:origin-left after:scale-x-0 hover:after:scale-x-100" href="_str1-index.html">
                            Home
                        </a>
                    </li>

                    <!-- Stream, active -->
                    <li class="">
                        <a class="group text-gray-900 dark:text-white relative inline-flex items-center gap-x-3 leading-10 px-3.5 xl:px-4.5 after:absolute after:top-[15px] after:left-0 after:bg-current-marker-dark after:transition-transform after:w-1.5 after:h-[9px] dark:after:bg-current-marker after:origin-left after:scale-x-100" href="_str1-streams-4.html">
                            Streams
                        </a>
                    </li>

                    <!-- Blog, inactive, sub-menu -->
                    <li class="relative [&>.sub-menu]:hover:visible [&>.sub-menu]:hover:animate-popper-pop-in [&>.sub-menu]:hover:opacity-100">
                        <a class="group text-gray-900 dark:text-white relative inline-flex items-center gap-x-3 leading-10 px-3.5 xl:px-4.5 after:absolute after:top-[15px] after:left-0 after:bg-current-marker-dark after:transition-transform after:w-1.5 after:h-[9px] dark:after:bg-current-marker after:origin-right hover:after:origin-left after:scale-x-0 hover:after:scale-x-100" href="_str1-blog.html">
                            Blog
                        <svg role="img" class="h-1.5 w-1.5 fill-gray-500 group-hover:fill-accent">
                            <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
                        </svg>
                        </a>
                        <ul class="sub-menu invisible absolute z-20 flex w-40 flex-col bg-white dark:bg-gray-700 py-2.5 text-sm font-bold opacity-0 shadow-2xl transition-all">
                            <li class="px-5.5">
                                <a class="flex items-center justify-between py-1.5 transition-colors text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-blog.html">
                                    Blog Feed
                                </a>
                            </li>
                            <li class="px-5.5">
                                <a class="flex items-center justify-between py-1.5 transition-colors text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single.html">
                                    Blog Post V1
                                </a>
                            </li>
                            <li class="px-5.5 relative [&>.sub-menu]:hover:visible [&>.sub-menu]:hover:animate-popper-pop-in [&>.sub-menu]:hover:opacity-100">
                                <a class="flex items-center justify-between py-1.5 transition-colors text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single-2.html">
                                    Blog Post V2
                                    <svg role="img" class="h-1.5 w-1.5 fill-accent">
                                        <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
                                    </svg>
                                </a>
                                <ul class="sub-menu invisible absolute z-20 flex w-40 flex-col bg-white dark:bg-gray-700 py-2.5 text-sm font-bold opacity-0 shadow-2xl transition-all left-full -top-2">
                                    <li class="px-5.5">
                                        <a class="flex items-center justify-between py-1.5 transition-colors text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single.html">
                                            Another Item
                                        </a>
                                    </li>
                                    <li class="px-5.5">
                                        <a class="flex items-center justify-between py-1.5 transition-colors text-gray-900 hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single-2.html">
                                            Other Level Item
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Header Controls -->
                <div class="flex ml-auto -mr-3">
                    <div class="flex items-center py-4 px-1 sm:px-2">
                        <label for="theme-toggle" class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" value="" id="theme-toggle" class="peer sr-only">
                        <span class="relative z-10 block h-6 w-11 rounded-full border-2 border-gray-900 after:absolute after:top-0.5 after:left-0.5 after:h-4 after:w-4 after:rounded-full after:bg-gray-900 after:transition-transform peer-checked:after:translate-x-[20px] dark:border-white dark:after:bg-white"></span>
                        <svg role="img" class="pointer-events-none absolute left-[5px] top-1 h-4 w-4 stroke-accent">
                            <use xlink:href="{{ asset('assets/img/sprite.svg#sun') }}"></use>
                        </svg>
                        <svg role="img" class="pointer-events-none absolute right-[5px] top-1 h-4 w-4 stroke-accent">
                            <use xlink:href="{{ asset('assets/img/sprite.svg#moon') }}"></use>
                        </svg>
                        </label>
                    </div>
                    <button class="js-menu-toggle -mr-2 inline-flex py-4 px-2 sm:px-3 lg:hidden xl:px-4">
                        <svg role="img" class="js-menu-toggle-icon-open h-6 w-6 fill-gray-900 dark:fill-white">
                            <use xlink:href="{{ asset('assets/img/sprite.svg#menu') }}"></use>
                        </svg>
                        <svg role="img" class="js-menu-toggle-icon-close hidden h-6 w-6 fill-gray-900 dark:fill-white">
                            <use xlink:href="{{ asset('assets/img/sprite.svg#menu-close') }}"></use>
                        </svg>
                    </button>
                </div>
            </nav>
        </div>
        <!-- Navbar Mobile -->
        <div class="js-mobile-menu p-t-[64px] fixed left-0 top-[64px] z-50 block h-[calc(100dvh-64px)] w-full translate-x-full overflow-auto bg-white dark:bg-gray-700 py-5 text-primary dark:text-white transition-transform duration-300 lg:hidden">
            <div class="container">
                <!-- Navigation (Mobile) -->
                <ul class="flex flex-col font-bold">
                    <li class="flex flex-wrap items-center gap-x-4 border-b border-b-gray-200/50 dark:border-b-gray-200/10">
                        <a class="flex-grow gap-x-1 py-4 leading-normal text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-index.html">
                            Home
                        </a>
                    </li>
                    <li class="flex flex-wrap items-center gap-x-4 border-b border-b-gray-200/50 dark:border-b-gray-200/10">
                        <a class="flex-grow gap-x-1 py-4 leading-normal text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-streams-4.html">
                            Streams
                        </a>
                    </li>
                    <li class="flex flex-wrap items-center gap-x-4 border-b border-b-gray-200/50 dark:border-b-gray-200/10">
                        <a class="flex-grow gap-x-1 py-4 leading-normal text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-blog.html">
                            Blog
                        </a>
                        <button class="js-mobile-submenu-toggle ml-auto inline-flex h-7 w-7 items-center justify-center transition-transform">
                            <svg role="img" class="sub-menu-toggle h-1.5 w-1.5 fill-accent">
                                <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
                            </svg>
                        </button>
                        <ul class="flex max-h-0 w-full flex-col overflow-hidden pl-4 text-sm transition-all duration-300 [&>li:last-child]:pb-4">
                            <li class="flex flex-wrap items-center gap-x-4">
                                <a class="flex-grow gap-x-1 py-2 text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-blog.html">
                                    Blog Feed
                                </a>
                            </li>
                            <li class="flex flex-wrap items-center gap-x-4">
                                <a class="flex-grow gap-x-1 py-2 text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single.html">
                                    Blog Post V1
                                </a>
                            </li>
                            <li class="flex flex-wrap items-center gap-x-4">
                                <a class="flex-grow gap-x-1 py-2 text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="_str1-single-2.html">
                                    Blog Post V2
                                </a>
                                <button class="js-mobile-submenu-toggle ml-auto inline-flex h-7 w-7 items-center justify-center transition-transform">
                                    <svg role="img" class="sub-menu-toggle h-1.5 w-1.5 fill-accent">
                                        <use xlink:href="{{ asset('assets/img/sprite.svg#plus') }}"></use>
                                    </svg>
                                </button>
                                <ul class="flex max-h-0 w-full flex-col overflow-hidden pl-4 transition-all duration-300">
                                    <li class="flex flex-wrap items-center gap-x-4">
                                        <a class="flex-grow gap-x-1 py-2 transition-colors hover:text-accent" href="_str1-single.html">
                                            Another Item
                                        </a>
                                    </li>
                                    <li class="flex flex-wrap items-center gap-x-4">
                                        <a class="flex-grow gap-x-1 py-2 transition-colors hover:text-accent" href="_str1-single-2.html">
                                            Other Level Item
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</div>