<?php

namespace App\Providers;

use App\Pages\MenuSeparator;
use App\Pages\PageService;
use App\Pages\PageServiceImpl;
use App\Pages\StandardPage;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    private $types = [
        StandardPage::class,
        MenuSeparator::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $service = new PageServiceImpl();

        foreach ($this->types as $type) {
            $service->register($type);
        }

        $this->app->instance(PageService::class, $service);
    }
}
