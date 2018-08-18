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
    $router->group([
        'prefix' => 'offers',
        'namespace' => 'Offer'
    ], function ($router) {
        $router->get('/', 'OfferController@index');
        $router->post('/', 'OfferController@store');
    });

    //Vouchers
});