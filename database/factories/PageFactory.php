<?php

use Faker\Generator as Faker;

$factory->define(\App\Pages\StandardPage::class, function (Faker $faker) {
    return [
        'type' => \App\Pages\StandardPage::class,
        'title' => $faker->domainWord,
        'slug' => $faker->slug(2),
        'in_menu' => true,
        'published' => false,
        'order' => 1,
        'data' => [
            'layout' => 'landing_page'
        ]
    ];
});

$factory->define(\App\Pages\Blocks\Text\TextBlock::class, function (Faker $faker) {
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

$factory->define(\App\Pages\Blocks\Gallery\GalleryBlock::class, function (Faker $faker) {
    return [
        'container' => 'c1',
        'order' => 1,
        'data' => [
            'heading' => 'test',
            'description' => '',
        ],
    ];
});