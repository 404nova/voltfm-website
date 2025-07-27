<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register the AdminAccess middleware with alias 'admin'
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAccess::class,
            'dj.access' => \App\Http\Middleware\DjAccessMiddleware::class,
            'editorial.access' => \App\Http\Middleware\EditorialAccessMiddleware::class,
            'permission' => \App\Http\Middleware\RoleBasedAccessMiddleware::class,
            'staff' => \App\Http\Middleware\StaffAccessMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
