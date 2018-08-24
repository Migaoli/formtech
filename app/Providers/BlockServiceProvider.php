<?php

namespace App\Providers;

use App\Blocks\Blocks;
use App\Blocks\BlockService;
use App\Blocks\Gallery\GalleryBlock;
use App\Blocks\Text\TextBlock;
use Illuminate\Support\ServiceProvider;

class BlockServiceProvider extends ServiceProvider
{
    private $types = [
        TextBlock::class,
        GalleryBlock::class,
    ];


    public function boot()
    {
        $blockService = new BlockService($this->types);

        $this->app->instance(Blocks::class, $blockService);
    }

}
