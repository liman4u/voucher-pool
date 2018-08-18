<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// Factory for Recipient Model
$factory->define(\App\Domain\Recipient\Models\Recipient::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->email
    ];

});

// Factory for Offer Model
$factory->define(App\Domain\Offer\Models\Offer::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'discount' => $faker->randomFloat(2, 0, 100)
    ];

});