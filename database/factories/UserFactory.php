<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Infra\Eloquents\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_temp' => null,
        'password' => $password ?: $password = bcrypt('secret'),
        'email_withdrawal'     => null,
        'email_before'         => null,
        'status'               => $faker->numberBetween(1, 2),
        'email_verify_token'   => str_random(10),
        'email_verify_time'    => $faker->date('Y-m-d H:i:s'),
        'email_verify_sent_at' => $faker->date('Y-m-d H:i:s'),
        'email_verify_status'  => 1,
        'remember_token' => str_random(10),
    ];
});
