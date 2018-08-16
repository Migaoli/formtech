<?php

use Faker\Generator as Faker;

$factory->define(\App\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'slug' => $faker->slug,
        'settings' => ['asd']
    ];
});
