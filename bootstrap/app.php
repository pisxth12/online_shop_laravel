<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminMiddlewareRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function (Router $router) {
        $router->middleware('web')->group(base_path('routes/admin.php'));
        $router->middleware('web')->group(base_path('routes/front.php'));
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.admin' => AdminMiddlewareRedirect::class,
            'auth.admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
