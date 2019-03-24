<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Pine\Impersonate\Test\Models\User;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = Hash::make('secret'),
        'remember_token' => Str::random(10),
    ];
});
