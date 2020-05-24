<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Api\Client;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'uuid' => (string) Str::uuid(),
        'number' => $faker->unique()->numerify('###########'),
        'name' => $faker->unique()->company,
        'address' => $faker->address,
        'email' => $faker->unique()->email,
        'join_date' => $faker->date(),
    ];
});
