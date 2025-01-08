<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->namespace('Branch')->prefix('branch')->name('branch.')->group(base_path('routes/branch.php'));
            Route::middleware('web')->namespace('Volunteer')->prefix('volunteer')->name('volunteer.')->group(base_path('routes/volunteer.php'));
            Route::middleware('web')->namespace('SuperAdmin')->prefix('super_admin')->name('super_admin.')->group(base_path('routes/super_admin.php'));
        },
      
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfNotAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
