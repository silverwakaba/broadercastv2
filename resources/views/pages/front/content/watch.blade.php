@extends('layout.front')
@section('title', 'Watch')
@section('content')
    <x-Valkivid.Container.Main background="https://cache-youtube-thumbnail.silverspoon.me/vi/GP5DJQVTTIE/maxresdefault.jpg">
        <section class="mb-20 lg:mb-32">
            <div class="mb-10 md:mb-12 lg:mb-16 xl:mb-20">
                <h2 class="text-2.5xl font-bold tracking-tighter text-gray-900 before:text-accent before:content-['.'] dark:text-white sm:text-3.5xl md:text-4xl lg:text-[62px] lg:leading-none">Title</h2>
            </div>
            <div class="grid grid-cols-12 gap-x-5 md:gap-x-6 lg:gap-x-7.5">
                <div class="col-span-full lg:col-span-9">
                    <iframe class="w-full aspect-[870/480]" src="https://www.youtube.com/embed/GP5DJQVTTIE"></iframe>
                </div>
                <div class="col-span-full lg:col-span-3 bg-white">
                    <iframe class="w-full aspect-[300/480] lg:-ml-7.5 lg:w-[calc(100%+30px)]" src="https://www.youtube.com/live_chat?v=GP5DJQVTTIE&embed_domain=broadercast.test&dark_theme=1" id="chat_embed"></iframe>
                </div>
            </div>
        </section>
    </x-Valkivid.Container.Main>
@endsection