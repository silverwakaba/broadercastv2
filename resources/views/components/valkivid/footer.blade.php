<footer id="site-footer">
    <div class="container">
        <div class="grid grid-cols-12 gap-x-5 gap-y-9 border-t border-gray-500/20 py-16 md:gap-x-6 lg:gap-x-7.5 lg:pt-[75px] lg:pb-[66px]">
            <div class="col-span-full lg:col-span-6">
                <a href="_str1-index.html">
                    <img class="w-20 h-10 hidden dark:block" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-light-50-transparent.png" alt="vTual Logo Light">
                    <img class="w-20 h-10 block dark:hidden" src="https://static.silverspoon.me/system/internal/image/logo/vtual/full-dark-50-transparent.png" alt="vTual Logo Dark">
                </a>
                <div class="pt-1">
                    <div class="mt-3 text-sm">
                        <p>The {{ config('app.name', 'vTual') }} network is a project designed to simplify the process of keeping up with your favorite content creators activity across platform; All in one convenient portal.</p>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6">
                <div>
                    <nav>
                        <ul class="grid grid-cols-9 gap-x-5 gap-y-4.5 text-sm font-bold md:gap-x-6 lg:gap-x-7.5">
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="index">Home</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="sponsors">Sponsors</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="contact">Contact</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="streams">Streams</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="about">About</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="shop-grid-3">Shop</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="blog">Blog</a>
                        </li>
                        <li class="col-span-3">
                            <a class="text-gray-900 transition-colors hover:text-accent dark:text-white dark:hover:text-accent" href="events">Events</a>
                        </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-5 left-2 z-20 flex flex-col-reverse items-center lg:bottom-auto lg:top-60 lg:left-7">
        <button class="js-vv-social-links-floating-toggle peer mt-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white transition-transform hover:scale-110 lg:mt-9 lg:hidden">
            <span class="sr-only">Toggle Social Links</span>
            <svg class="aspect-square w-4" fill="currentColor">
                <use xlink:href="{{ asset('assets/img/social-icons.svg#share') }}"></use>
            </svg>
        </button>
        <ul class="js-vv-social-links-floating vv-social-list-color hidden w-8 flex-col gap-y-4 peer-[.active]:flex lg:flex lg:gap-y-9">
            <li>
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white transition-transform hover:scale-110" href="https://twitch.tv">
                    <svg class="aspect-square w-3.5" fill="currentColor">
                        <use xlink:href="{{ asset('assets/img/social-icons.svg#twitch') }}"></use>
                    </svg>
                </a>
            </li>
            <li>
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white transition-transform hover:scale-110" href="https://twitter.com">
                    <svg class="aspect-square w-3.5" fill="currentColor">
                        <use xlink:href="{{ asset('assets/img/social-icons.svg#twitter') }}"></use>
                    </svg>
                </a>
            </li>
            <li>
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white transition-transform hover:scale-110" href="https://www.facebook.com">
                    <svg class="aspect-square w-3.5" fill="currentColor">
                        <use xlink:href="{{ asset('assets/img/social-icons.svg#facebook') }}"></use>
                    </svg>
                </a>
            </li>
            <li>
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white transition-transform hover:scale-110" href="http://instagram.com">
                    <svg class="aspect-square w-3.5" fill="currentColor">
                        <use xlink:href="{{ asset('assets/img/social-icons.svg#instagram') }}"></use>
                    </svg>
                </a>
            </li>
            <li>
                <a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white transition-transform hover:scale-110" href="https://discord.com">
                    <svg class="aspect-square w-3.5" fill="currentColor">
                        <use xlink:href="{{ asset('assets/img/social-icons.svg#discord') }}"></use>
                    </svg>
                </a>
            </li>
        </ul>
    </div>
</footer>