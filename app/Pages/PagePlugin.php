<?php


namespace App\Pages;


use App\Pages\Blocks\Blocks;
use App\Pages\Blocks\BlockService;
use Illuminate\Support\ServiceProvider;

class PagePlugin extends ServiceProvider
{
    private $pages = [
        MarkdownPage::class,
        StandardPage::class,
        MenuSeparator::class,
        ErrorPage::class,
    ];

    private $blocks = [
        \App\Pages\Blocks\Text\TextBlock::class,
        \App\Pages\Blocks\Text\TextImageBlock::class,
        \App\Pages\Blocks\Text\TextIconBlock::class,
        \App\Pages\Blocks\Gallery\GalleryBlock::class,
    ];


    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Controllers/routes.php');

        $this->registerPages();
        $this->registerBlocks();
    }

    private function registerPages()
    {
        $service = new PageServiceImpl();

        foreach ($this->pages as $type) {
            $service->register($type);
        }

        $this->app->instance(PageService::class, $service);
    }

    private function registerBlocks()
    {
        $blockService = new BlockService($this->blocks);

        $this->app->instance(Blocks::class, $blockService);
    }
}