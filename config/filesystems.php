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

    'default' => env('FILESYSTEM_DISK', 'local'),

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
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3public' => [
            'driver'        => 's3',
            'bucket'        => env('B2_BUCKET_1'),
            'region'        => env('B2_REGION'),
            'key'           => env('B2_KEY'),
            'secret'        => env('B2_SECRET'),
            'endpoint'      => env('B2_ENDPOINT', 'https://s3.us-west-002.backblazeb2.com'),
            'visibility'    => 'public',
        ],

        's3private' => [
            'driver'        => 's3',
            'bucket'        => env('B2_BUCKET_2'),
            'region'        => env('B2_REGION'),
            'key'           => env('B2_KEY'),
            'secret'        => env('B2_SECRET'),
            'endpoint'      => env('B2_ENDPOINT', 'https://s3.us-west-002.backblazeb2.com'),
            'visibility'    => 'private',
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
