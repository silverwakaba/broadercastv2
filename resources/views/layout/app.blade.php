<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
        <title>@yield('title', 'Page Title') | {{ config('app.name', 'vTual') }}</title>
        <meta name="description" content="@yield('description', 'description')">
        <meta name="keywords" content="@yield('keywords', config('app.keywords'))">
        <meta name="robots" content="index, follow">
        <link rel="shortcut icon" href="https://static.pub.spnd.uk/system/internal/image/logo/vtual/logo-50.png">
        <link rel="apple-touch-icon" sizes="120x120" href="https://static.pub.spnd.uk/system/internal/image/logo/vtual/logo-120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="https://static.pub.spnd.uk/system/internal/image/logo/vtual/logo-152.png">
        <meta property="og:title" content="@yield('title', 'Page Title') | {{ config('app.name', 'vTual') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="@yield('image', config('app.image'))">
        <meta property="og:description" content="@yield('description', config('app.description'))">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', 'Page Title') | {{ config('app.name', 'vTual') }}">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:image" content="@yield('image', config('app.image'))">
        <meta name="twitter:description" content="@yield('description', config('app.description'))">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    </head>
    <body @class(["hold-transition", "dark-mode", "layout-navbar-fixed", "layout-top-nav" => !request()->routeIs('apps.*')])>
        <div class="wrapper">
            <x-Adminlte.Main />
        </div>
        {!! HCaptcha::renderJs('en') !!}
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jscroll@2.4.1/jquery.jscroll.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </body>
</html>