<?php

namespace App\Providers;

use App\Blocks\Blocks;
use App\Blocks\BlockService;
use App\Blocks\TextBlock;
use Illuminate\Support\ServiceProvider;

class BlockServiceProvider extends ServiceProvider
{
    private $types = [
        TextBlock::class,
    ];


    public function boot()
    {
        $blockService = new BlockService($this->types);

        $this->app->instance(Blocks::class, $blockService);
    }

}
