<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'start_date' => $faker->date(),
        'end_date' => $faker->date(),
        'start_time' => $faker->time(),
        'end_time' => $faker->time(),
        'address' => $faker->address,
        'position_latitude' => $faker->latitude,
        'position_longitude' => $faker->longitude,
        'has_sponsors' => $faker->boolean,
        'event_type_id' => $faker->numberBetween(0, 5),
        'user_id' => 1
    ];
});
