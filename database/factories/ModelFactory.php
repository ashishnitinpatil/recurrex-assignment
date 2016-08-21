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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\en_US\Person($faker));
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'mobile' => str_random(10),
        'profile_pic' => 'http://viverealmeglio.it/wp-content/uploads/2015/01/uova-colesterolo.png',
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => true]);
});
