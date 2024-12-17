<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */

    'default' => env('MAIL_MAILER', 'failover'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover", "roundrobin"
    |
    */

    'mailers' => [
        // Debug SMTP
        'debug' => [
            'transport'     => 'smtp',
            'host'          => env('MAILER_DEBUG_HOST', 'sandbox.smtp.mailtrap.io'),
            'port'          => env('MAILER_DEBUG_PORT', 2525),
            'encryption'    => env('MAILER_DEBUG_ENCRYPTION', 'tls'),
            'username'      => env('MAILER_DEBUG_USERNAME'),
            'password'      => env('MAILER_DEBUG_PASSWORD', null),
            'timeout'       => null,
            'from'          => [
                'name'      => env('MAIL_FROM_NAME', 'vTual Mailer Debug'),
                'address'   => env('MAIL_FROM_ADDRESS', 'vtual@debug.net'),
            ],
        ],

        // Custom SMTP
        'smtp' => [
            'transport'     => 'smtp',
            'host'          => env('MAILER_DEFAULT_HOST', 'notify.spnd.uk'),
            'port'          => env('MAILER_DEFAULT_PORT', 587),
            'encryption'    => env('MAILER_DEFAULT_ENCRYPTION', 'tls'),
            'username'      => env('MAILER_DEFAULT_USERNAME'),
            'password'      => env('MAILER_DEFAULT_PASSWORD', null),
            'timeout'       => null,

            // Useless when using failover mode
            'from'          => [
                'name'      => env('MAILER_DEFAULT_NAME', 'vTual Mailer'),
                'address'   => env('MAILER_DEFAULT_USERNAME', 'vtual@no-reply.spnd.uk'),
            ],
        ],

        // Mail Backup 1 - Brevo Free-Tier
        'brevo' => [
            'transport'     => 'smtp',
            'host'          => env('MAILER_BACKUP_1_HOST', 'smtp-relay.brevo.com'),
            'port'          => env('MAILER_BACKUP_1_PORT', 587),
            'encryption'    => env('MAILER_BACKUP_1_ENCRYPTION', 'tls'),
            'username'      => env('MAILER_BACKUP_1_USERNAME'),
            'password'      => env('MAILER_BACKUP_1_PASSWORD'),
            'timeout'       => null,

            // Useless when using failover mode
            'from'          => [
                'name'      => env('MAILER_BACKUP_1_NAME', 'vTual Mailer'),
                'address'   => env('MAILER_BACKUP_1_ADDRESS', 'vtual@no-reply.spnd.uk'),
            ],
        ],

        // Mail Backup 2 - Zepto Paid-Tier (TBA)
        'zepto' => [
            'transport'     => 'smtp',
            'host'          => env('MAILER_BACKUP_2_HOST', 'smtp.zeptomail.com'),
            'port'          => env('MAILER_BACKUP_2_PORT', 587),
            'encryption'    => env('MAILER_BACKUP_2_ENCRYPTION', 'tls'),
            'username'      => env('MAILER_BACKUP_2_USERNAME'),
            'password'      => env('MAILER_BACKUP_2_PASSWORD'),
            'timeout'       => null,

            // Useless when using failover mode
            'from'          => [
                'name'      => env('MAILER_BACKUP_2_NAME', 'vTual Mailer'),
                'address'   => env('MAILER_BACKUP_2_ADDRESS', 'vtual@no-reply-backup-1.spnd.uk'),
            ],
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        // Email Failover - Scheme: smtp > free-tier > paid tier
        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp', 'brevo',
                // 'zepto' // not yet paid
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */

    'from' => [
        'name'      => env('MAIL_FROM_NAME', 'vTual Mailer'),
        'address'   => env('MAIL_FROM_ADDRESS', 'vtual@no-reply.spnd.uk'),
    ],
];
