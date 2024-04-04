<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'BASE') }} Mailer</title>
    </head>
    <body>
        <div id="content">
            <p>Greetings from {{ config('app.name', 'BASE') }},</p>
            @yield('content')
            <p>Sincerely,<br />The {{ config('app.name', 'BASE') }} Team</p>
        </div>
    </body>
</html>