<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Week;
use Faker\Generator as Faker;

$factory->define(Week::class, function (Faker $faker) {
    return [
        'year' => $faker->word,
        'week' => $faker->word,
        'price_start' => $faker->word,
        'price_monday_morning' => $faker->word,
        'price_monday_night' => $faker->word,
        'price_tuesday_morning' => $faker->word,
        'price_tuesday_night' => $faker->word,
        'price_wednesday_morning' => $faker->word,
        'price_wednesday_night' => $faker->word,
        'price_thursday_morning' => $faker->word,
        'price_thursday_night' => $faker->word,
        'price_friday_morning' => $faker->word,
        'price_friday_night' => $faker->word,
        'price_saturday_morning' => $faker->word,
        'price_saturday_night' => $faker->word,
    ];
});
