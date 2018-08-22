<?php


namespace App\Builder;


use App\Blocks\Block;
use App\Page;
use Illuminate\View\Factory;
use Illuminate\View\View;

class PageBuilder
{
    private $theme;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * PageBuilder constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->theme = config('cms.theme');
        $this->factory = $factory;
    }


    public function build(Page $page): string
    {
        $layout = $this->getLayout($page->layout);

        $view = $this->createView($layout['template']);

        $blocks = $page->blocks
            ->sortBy('position')
            ->mapToGroups(function (Block $block) {
                return [$block->container => $this->buildBlock($block)];
            });


        $view->with('page', $page)
            ->with('blocks', $blocks);

        return $view->render();
    }

    public function buildBlock(Block $block): string
    {
        $view = $this->createView("blocks.{$block->name()}");

        $view->with('block', $block);

        return $view->render();
    }

    private function getLayout($name)
    {
        return $this->theme['layouts'][$name];
    }

    private function createView($name): View
    {
        return $this->factory->make("{$this->theme['name']}::{$name}");
    }
}