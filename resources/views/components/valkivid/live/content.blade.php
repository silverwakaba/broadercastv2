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
    <div @class(["scrolling-pagination" => isset($feeds->links)])>
        @if(($feeds) && (count($feeds->data) >= 1))
            <div class="grid gap-y-7.5 grid-cols-12 sm:gap-x-7.5">
                @foreach($feeds->data AS $data)
                    <div class="col-span-full sm:col-span-6 lg:col-span-3 mt-10 mb-10">
                        <figure class="mb-5">
                        <a class="group relative block h-full overflow-hidden bg-gray-900" href="{{ $data->link }}" target="_blank">
                            <img class="aspect-[270/160] w-full object-cover transition-all duration-300 group-hover:scale-110 group-hover:opacity-75" src="{{ $data->thumbnail }}" alt="{{ $data->title }}">
                            <div class="absolute bg-black uppercase text-white text-xs leading-none truncate font-bold left-3.5 top-3 px-2 py-1">{{ $data->duration }}</div>
                            <span class="absolute top-1/2 left-1/2 flex aspect-square -translate-x-2/4 -translate-y-2/4 items-center justify-center w-10">
                                <svg role="img" class="fill-white ml-[2px] aspect-[18/22] w-7">
                                    <use xlink:href="{{ asset('assets/img/sprite.svg#play') }}"></use>
                                </svg>
                            </span>
                        </a>
                        </figure>
                        <div class="flex gap-x-3">
                            <div class="shrink-0">
                                <img class="h-10" src="{{ $data->profile->avatar }}" alt="{{ $data->profile->name }}">
                            </div>
                            <div class="min-w-0">
                                <h3 class="mb-1 font-bold text-base leading-tight text-gray-900 dark:text-white truncate w-full">{{ $data->title }}</h3>
                                <ul class="flex flex-col gap-y-1.5 text-sm leading-none font-medium">
                                    <li><a href="#">{{ $data->profile->name }}</a></li>
                                    <li>{{ $data->timestamp_for_human }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="href-pagination">
                    <a href="{{ $feeds->links->next }}" class="scrolling-paging">Loading...</a>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center">
                <p>It looks so quiet now...</p>
            </div>
        @endif
    </div>
</section>