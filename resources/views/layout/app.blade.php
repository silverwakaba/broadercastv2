<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Page') | {{ config('app.name', 'BASE') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/css/dataTables.bootstrap4.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
        @vite(['resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper" hx-boost="false">
            <x-adminlte.main />
        </div>
        <script src="https://cdn.jsdelivr.net/npm/htmx.org@1.9.11/dist/htmx.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>

        <!-- All custom script goes here -->
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                });
            });
        </script>
    </body>
</html>