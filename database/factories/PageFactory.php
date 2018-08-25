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

$factory->define(\App\Blocks\Text\TextBlock::class, function (Faker $faker) {
    return [
        'container' => 'c1',
        'order' => 1,
        'data' => [
            'heading' => $faker->sentence,
            'heading_type' => 'h3',
            'alignment' => 'left',
            'content' => $faker->realText(400),
        ],
    ];
});

$factory->define(\App\Blocks\Gallery\GalleryBlock::class, function (Faker $faker) {
    return [
        'container' => 'c1',
        'position' => 1,
        'data' => [
            'heading' => 'test',
            'description' => '',
        ],
    ];
});