<?php

namespace App\Context\Api\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\Router;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register routing services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    /**
     * Boot the routing services for the api context.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->group([
            'prefix' => 'api',
            'namespace' => 'App\Context\Api\Http\Controllers',
        ], function ($router) {
            require __DIR__.'/../routes.php';
        });
    }

}