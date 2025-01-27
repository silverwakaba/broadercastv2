<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default'   => env('FILESYSTEM_DISK', 'local'),
    'public'    => env('FILESYSTEM_DISK_PUBLIC', 'vtlPublicS3'),
    'private'   => env('FILESYSTEM_DISK_PRIVATE', 'vtlPrivateS3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver'    => 'local',
            'root'      => storage_path('app'),
            'throw'     => false,
        ],

        'public' => [
            'driver'        => 'local',
            'root'          => storage_path('app/public'),
            'url'           => env('APP_URL').'/storage',
            'visibility'    => 'public',
            'throw'         => false,
        ],

        // Backblaze B2 - Discontinued

        // 's3public' => [
        //     'driver'        => 's3',
        //     'bucket'        => env('B2_BUCKET_1'),
        //     'region'        => env('B2_REGION'),
        //     'key'           => env('B2_KEY'),
        //     'secret'        => env('B2_SECRET'),
        //     'endpoint'      => env('B2_ENDPOINT', 'https://s3.us-west-002.backblazeb2.com'),
        //     'visibility'    => 'public',
        //     'throw'         => true,
        // ],

        // 's3private' => [
        //     'driver'        => 's3',
        //     'bucket'        => env('B2_BUCKET_2'),
        //     'region'        => env('B2_REGION'),
        //     'key'           => env('B2_KEY'),
        //     'secret'        => env('B2_SECRET'),
        //     'endpoint'      => env('B2_ENDPOINT', 'https://s3.us-west-002.backblazeb2.com'),
        //     'visibility'    => 'private',
        //     'throw'         => true,
        // ],

        // 's3publicinternal' => [
        //     'driver'        => 's3',
        //     'bucket'        => env('R2_BUCKET_1'),
        //     'region'        => env('R2_REGION'),
        //     'key'           => env('R2_KEY'),
        //     'secret'        => env('R2_SECRET'),
        //     'endpoint'      => env('R2_ENDPOINT', 'https://s3.us-west-002.backblazeb2.com'),
        //     'visibility'    => 'public',
        // ],

        // Cloudflare R2
        // The endpoint 'c3f9b55c216de42fca1d1579c5b41ac3' bound to specific account

        // Silverspoon
        'spnPublicS3'   => [
            'driver'        => 's3',
            'bucket'        => env('R2_BUCKET_1'),
            'region'        => env('R2_REGION'),
            'key'           => env('R2_KEY'),
            'secret'        => env('R2_SECRET'),
            'endpoint'      => env('R2_ENDPOINT'),
            'visibility'    => 'public',
        ],

        // vTual Public
        'vtlPublicS3'   => [
            'driver'        => 's3',
            'bucket'        => env('R2_BUCKET_2'),
            'region'        => env('R2_REGION'),
            'key'           => env('R2_KEY'),
            'secret'        => env('R2_SECRET'),
            'endpoint'      => env('R2_ENDPOINT'),
            'visibility'    => 'public',
            'throw'         => true,
        ],

        // vTual Private
        'vtlPrivateS3'  => [
            'driver'        => 's3',
            'bucket'        => env('R2_BUCKET_3'),
            'region'        => env('R2_REGION'),
            'key'           => env('R2_KEY'),
            'secret'        => env('R2_SECRET'),
            'endpoint'      => env('R2_ENDPOINT'),
            'visibility'    => 'private',
            'throw'         => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
