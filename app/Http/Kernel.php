<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Foundation\Application;

class Kernel extends HttpKernel
{
    public function __construct(Application $app, Router $router)
    {
        $this->reorderMiddlewarePriority();
        parent::__construct($app, $router);
    }

    /**
     * Reorders the parent classes $middlewarePriority attribute which decides which middleware
     * should be executed before others.
     *
     * In the case of a refresh of a JWT we need to ensure that the Refresh middleware acts before
     * the Authentication middleware.
     */
    private function reorderMiddlewarePriority()
    {
        $middlewarePriority = $this->middlewarePriority;

        // Ensure that RefreshToken middleware executes, before Authenticate middleware.
        $insert = \App\Http\Middleware\RefreshToken::class;
        // Find the index of the middleware to be inserted before
        $before = array_search(\Illuminate\Auth\Middleware\Authenticate::class, $middlewarePriority);
        // Insert the new middleware
        array_splice($middlewarePriority, $before, 0, [$insert]);

        $this->middlewarePriority = $middlewarePriority;
    }

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\CookieAuth::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \App\Http\Middleware\Role::class,
        'refresh' => \App\Http\Middleware\RefreshToken::class,
        'admin.or' => \App\Http\Middleware\AdminOr::class,
    ];
}
