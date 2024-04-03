<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ config('app.name', 'BASE') }} Mailer</title>
    </head>
    <body>
        <div id="content">
            @yield('content')
            <p>Thanks,<br />The {{ config('app.name', 'BASE') }} Team</p>
        </div>
    </body>
</html>