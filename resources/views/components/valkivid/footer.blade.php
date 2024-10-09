<footer id="site-footer">
    <div class="container">
        <div class="grid grid-cols-12 gap-x-5 gap-y-9 border-t border-gray-500/20 py-16 md:gap-x-6 lg:gap-x-7.5 lg:pt-[75px] lg:pb-[66px]">
            <div class="col-span-full lg:col-span-6">
                <a href="{{ route('index') }}">
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
</footer>