<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
*/

$router->group(['prefix' => 'v1'], function ($router) {

    //Recipients
    $router->group([
        'prefix' => 'recipients',
        'namespace' => 'Recipient'
    ], function ($router) {
        $router->get('/', 'RecipientController@index');
        $router->post('/', 'RecipientController@store');
    });

    //Offers

    //Vouchers
});