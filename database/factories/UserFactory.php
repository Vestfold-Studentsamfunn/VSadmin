<?php

use Faker\Generator as Faker;

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
$factory->define(App\Members::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'payed' => $faker->numberBetween($min = -1, $max = 2),
        'payedDate' => $faker->dateTimeThisYear($max = 'now'),
        'semesters' => $faker->numberBetween($min = 1, $max = 2),
        'u20' => $faker->numberBetween($min = 0, $max = 1),
        'noEmail' => $faker->numberBetween($min = 0, $max = 1),
        'noPhone' => $faker->numberBetween($min = 0, $max = 1),
        'address' => $faker->streetAddress(),
        'postalCode' => $faker->postcode(),
        'postalArea' => $faker->city(),
        'department' => $faker->randomElement($array = array ('TEKMAR','HUT','HS', 'HE')),
        'birthDate' => $faker->dateTimeBetween($startDate = '-31 years', $endDate = '-18 years')->format('Y-m-d')
    ];
});
