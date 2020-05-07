<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Models\Mail::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3, true),
        'body' => $faker->text,
        'scheduled_at' => $faker->time('H:i:s'),
    ];
});
