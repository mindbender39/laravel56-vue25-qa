<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Answer::class, function (Faker $faker) {
    return [
        'user_id' => \App\Models\User::pluck('id')->random(),
        'body' => $faker->paragraphs(rand(3, 7), true),
        'votes_count' => rand(0, 5)
    ];
});
