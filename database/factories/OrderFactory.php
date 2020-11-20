<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use App\Models\OrderStatus;
use App\Models\User;

$factory->define(Order::class, function (Faker $faker) {

    $user = User::find(rand(1, User::count()));

    return [
        'user_id' => $user->id,
        'status_id' => rand(1, OrderStatus::count()),
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_phone' => $user->phone,
        'user_address' => $user->address
    ];
});
