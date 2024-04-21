<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'email' =>  $faker->unique()->safeEmail,
        'remember_token' => Str::random(10),
    ];
});
