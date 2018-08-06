<?php

use Faker\Generator as Faker;

$factory->define(App\Booking::class, function (Faker $faker) {
    return [
        'customer_id' => factory(App\Customer::class)->create(),
        'date' => $faker->dateTimeThisMonth()->format("Y-m-d"),
        'time' => $faker->dateTimeThisMonth()->format("H:i:s"),
        'description' => $faker->paragraph()
    ];
});
