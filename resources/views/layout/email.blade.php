<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'BASE') }} Mailer</title>
    </head>
    <body>
        <div id="content">
            <p>Greetings from {{ config('app.name', 'BASE') }},</p>
            <br />
            @yield('content')
            <br />
            <p>Sincerely,<br />The {{ config('app.name', 'BASE') }} Team</p>
            <hr />
            <p><small>Since we send out notification emails like this in large quantities, it may end up in your spam box. Whitelist this email so that you can receive notifications smoothly in the future.</small></p>
        </div>
    </body>
</html>