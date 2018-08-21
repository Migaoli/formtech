<?php

use Faker\Generator as Faker;

$factory->define(\App\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->domainWord,
        'slug' => $faker->slug(2),
        'layout' => 'landing_page',
        'settings' => ['css' => ''],
    ];
});

$factory->define(\App\Blocks\TextBlock::class, function (Faker $faker) {
    return [
        'container' => 'c1',
        'position' => 1,
        'data' => [
            'heading' => $faker->sentence,
            'heading_alignment' => 'left',
            'heading_type' => 'h1',
            'content' => '# Hello world!',
        ],
    ];
});
