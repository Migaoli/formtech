<?php

use Faker\Generator as Faker;

$factory->define(\App\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->domainWord,
        'slug' => $faker->slug(2),
        'layout' => 'normal',
        'settings' => ['css' => ''],
    ];
});

$factory->define(\App\Blocks\TextBlock::class, function (Faker $faker) {
    return [
        'data' => [
            'heading' => $faker->sentence,
            'heading_alignment' => 'left',
            'heading_type' => 'h1',
            'content' => '# Hello world!',
        ],
    ];
});
