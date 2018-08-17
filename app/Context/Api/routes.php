<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/

$router->group(['prefix' => 'v1'], function ($router) {

    $router->get('/test', function () use ($router) {
        return "Hello";
    });

    //Recipients


    //Offers


    //Vouchers
});