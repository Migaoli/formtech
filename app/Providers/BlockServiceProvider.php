<?php

namespace App\Providers;

use App\Blocks\Blocks;
use App\Blocks\BlockService;
use App\Blocks\Gallery\GalleryBlock;
use App\Blocks\Text\TextBlock;
use App\Blocks\Text\TextIconBlock;
use App\Blocks\Text\TextImageBlock;
use Illuminate\Support\ServiceProvider;

class BlockServiceProvider extends ServiceProvider
{
    private $types = [
        TextBlock::class,
        GalleryBlock::class,
        TextImageBlock::class,
        TextIconBlock::class,
    ];


    public function boot()
    {
        $blockService = new BlockService($this->types);

        $this->app->instance(Blocks::class, $blockService);
    }

}
