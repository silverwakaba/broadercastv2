<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'vTual') }} Mailer</title>
    </head>
    <body>
        <p>Greetings from {{ config('app.name', 'vTual') }}.</p>
        <br />
        @yield('content')
        <br />
        <p>Best regards,<br />The {{ config('app.name', 'vTual') }} Team</p>
        <hr />
        <p><small>Verify the authenticity and validity of the email sender by referring to the official notice regarding our official email addresses, <a href="https://help.silverspoon.me/docs/silverspoon/domain" target="_blank" rel="noopener">which you can read here</a>.</small></p>
        <p><small>Since we send out email notification like this in large quantities, this email may end up in your spam mailbox. You can whitelist this email address so that you can receive notifications smoothly in the future.</small></p>
    </body>
</html>