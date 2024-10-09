<div>
    @if(isset($title))
        <div class="page-heading py-6 md:py-12">
            <div class="container">
                <div class="mb-2 flex items-baseline gap-x-3 lg:gap-x-4.5">
                    <h1 class="relative mb-3 text-3xl font-bold leading-none tracking-tighter text-gray-900 dark:text-white sm:text-4xl md:text-5xl lg:text-7xl xl:text-[84px]">{{ $title }}</h1>
                </div>
            </div>
        </div>
    @endif
    <div class="pt-20 pb-20">
        <div class="container">
            {{ $slot }}
        </div>
    </div>
    <div class="vv-body-bg absolute inset-0 max-h-[1144px] {{ $backgroundClass }} bg-no-repeat bg-top bg-cover -z-10 opacity-10 dark:opacity-100">
        <div class="absolute inset-0 bg-black mix-blend-color z-[1]"></div>
        <div class="absolute inset-0 dark:bg-gray-900 mix-blend-multiply z-[2]"></div>
        <div class="absolute inset-0 dark:bg-gray-600 mix-blend-screen z-[3] opacity-40"></div>
    </div>
    @if($background == 'custom')
        <style>
            .bg-custom-this-page {
                background-image: url('{{ $backgroundURL }}');
            }
        </style>
    @endif
</div>