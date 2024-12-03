<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/mental-health',
    )
    ->withMiddleware(function(Middleware $middleware){
        // Alias Middleware
        $middleware->alias([
            // Role-related
            'role'                  => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'            => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'    => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            // Checker
            'link_signature'        => \App\Http\Middleware\LinkSignature::class,
        ]);
    })
    ->withExceptions(function(Exceptions $exceptions){
        //
    })->create();
