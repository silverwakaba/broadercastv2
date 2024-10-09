<div class="header-wrapper text-white">
    <header id="site-header" class="text-white">
        <div class="max-w-[1360px] mx-auto px-5">
            <nav class="flex min-h-[64px] items-center gap-x-6 lg:gap-x-11 py-1 lg:min-h-[90px] lg:py-4">
                <div class="shrink-0">
                    <a href="{{ route('index') }}">
                        <img class="w-20 h-10 hidden dark:block" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-light-50-transparent.png" alt="vTual Logo Light">
                        <img class="w-20 h-10 block dark:hidden" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-dark-50-transparent.png" alt="vTual Logo Dark">
                    </a>
                </div>
                <ul class="hidden lg:gap-x-0 xl:gap-x-6 text-sm font-bold lg:flex">
                    <x-Valkivid.NavLink value="Home" route="index" mode="desktop" />
                    <x-Valkivid.NavDropdown value="Content" route="content.*" mode="desktop">
                        <x-Valkivid.NavDropdownLink value="Live" route="content.live" mode="desktop" />
                        <x-Valkivid.NavDropdownLink value="Scheduled" route="content.scheduled" mode="desktop" />
                        <x-Valkivid.NavDropdownLink value="Archived" route="content.archived" mode="desktop" />
                        <x-Valkivid.NavDropdownLink value="Uploaded" route="content.uploaded" mode="desktop" />
                        <x-Valkivid.NavDropdownLink value="Setting" route="content.setting" mode="desktop" />
                    </x-Valkivid.NavDropdown>
                    <x-Valkivid.NavDropdown value="Creator" route="creator.*" mode="desktop">
                        <x-Valkivid.NavDropdownLink value="Discovery" route="creator.index" mode="desktop" />
                    </x-Valkivid.NavDropdown>
                </ul>
                <div class="flex ml-auto -mr-3">
                    <div class="invisible flex items-center py-4 px-1 sm:px-2">
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
        <div class="js-mobile-menu p-t-[64px] fixed left-0 top-[64px] z-50 block h-[calc(100dvh-64px)] w-full translate-x-full overflow-auto bg-white dark:bg-gray-700 py-5 text-primary dark:text-white transition-transform duration-300 lg:hidden">
            <div class="container">
                <ul class="flex flex-col font-bold">
                    <x-Valkivid.NavLink value="Test Mobile" route="index" mode="mobile" />
                    <x-Valkivid.NavDropdown value="Content" route="content.*" mode="mobile">
                        <x-Valkivid.NavDropdownLink value="Live" route="content.live" mode="mobile" />
                        <x-Valkivid.NavDropdownLink value="Scheduled" route="content.scheduled" mode="mobile" />
                        <x-Valkivid.NavDropdownLink value="Archived" route="content.archived" mode="mobile" />
                        <x-Valkivid.NavDropdownLink value="Uploaded" route="content.uploaded" mode="mobile" />
                        <x-Valkivid.NavDropdownLink value="Setting" route="content.setting" mode="mobile" />
                    </x-Valkivid.NavDropdown>
                    <x-Valkivid.NavDropdown value="Creator" route="creator.*" mode="mobile">
                        <x-Valkivid.NavDropdownLink value="Discovery" route="creator.index" mode="mobile" />
                    </x-Valkivid.NavDropdown>
                </ul>
            </div>
        </div>
    </header>
</div>