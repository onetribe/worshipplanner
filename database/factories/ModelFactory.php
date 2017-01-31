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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Song::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->sentence(2),
        'alternative_title' => $faker->sentence(2),
        'team_id' => 1,
        'lyrics' => $faker->paragraph(),
        'copyrights' => $faker->sentence(3),
        'ccli' => $faker->randomNumber(6),
        'default_key' => $faker->randomElement(config('songs.keys')),
        'default_tempo' => $faker->randomElement(config('songs.keys')),
        'youtube' => $faker->url,
    ];
});
