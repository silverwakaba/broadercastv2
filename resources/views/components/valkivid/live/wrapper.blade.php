<section class="mb-10 mt-9">
    <div class="flex justify-between items-baseline mb-10 md:mb-12 lg:mb-16 xl:mb-[60px]">
        <h2 class="text-2.5xl font-bold tracking-tighter text-gray-900 before:text-accent before:content-['.'] dark:text-white sm:text-3.5xl md:text-4xl lg:text-[62px] lg:leading-none">{{ $title }}</h2>
        @if(isset($link))
            <div class="flex gap-4 sm:gap-8 items-baseline">
                <ul class="flex gap-4 sm:gap-8">
                    <li>
                        <a class="group" href="{{ $link }}">
                            <span class="text-2xl tracking-tighter text-gray-900 before:text-accent dark:text-white sm:text-3xl md:text-3.5xl lg:leading-none">More...</span>
                        </a>
                    </li> 
                </ul>
            </div>
        @endif
    </div>
    <div class="grid gap-y-7.5 grid-cols-12 sm:gap-x-7.5 scrolling-pagination">
        {{ $slot }}
    </div>
</section>