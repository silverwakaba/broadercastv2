<!DOCTYPE html>
<html lang="en" class="h-full dark">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
        <title>@yield('title', 'Page') | {{ config('app.name', 'vTual') }}</title>
        <meta name="author" content="Kurokuma Wakaba">
        <meta name="keywords" content="youtube, twitch, stream, streamer, creator, content creator">
        <meta name="description" content="The vTual network is a project designed to simplify the process of keeping up with your favorite content creators activity across platform; All in one convenient portal.">
        <link rel="shortcut icon" href="https://static.silverspoon.me/system/internal/image/logo/vtual/logo-50.png">
        <link rel="apple-touch-icon" sizes="120x120" href="https://static.silverspoon.me/system/internal/image/logo/vtual/logo-120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="https://static.silverspoon.me/system/internal/image/logo/vtual/logo-152.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/vendors/common/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/vendors/common/swiper/css/swiper-bundle.min.css" rel="stylesheet">
        <link href="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/css/style.min.css" rel="stylesheet">
        <link href="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/css/custom.css" rel="stylesheet">
        @vite(['resources/css/app.css'])
    </head>
    <body class="relative z-10 antialiased font-base text-gray-500 text-sm font-medium lg:text-base h-full bg-white dark:bg-gray-900 dark:text-gray">
        <div id="site-wrapper" class="flex flex-col h-full js-site-wrapper">
            <x-Valkivid.Main />
        </div>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jscroll@2.4.1/jquery.jscroll.min.js"></script>
        <script src="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/vendors/common/glightbox/js/glightbox.min.js"></script>
        <script src="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/vendors/common/swiper/js/swiper-bundle.min.js"></script>
        <script src="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/js/common.min.js"></script>
        <script src="https://static.silverspoon.me/system/internal/template/valkvid/3.0.1/js/init.min.js"></script>
        @vite(['resources/js/app.js'])
    </body>
</html>