<?php


namespace App\Pages\Builder;


use App\Pages\Blocks\Block;
use App\Pages\StandardPage;
use Illuminate\View\Factory;
use Illuminate\View\View;

class StandardPageBuilder
{

    /** @var $factory Factory */
    private $factory;

    private $theme;

    /**
     * StandardPageBuilder constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
        $this->theme = config('cms.theme');
    }

    public function build(StandardPage $page): View
    {
        return $this
            ->getView('layouts.' . $page->layout())
            ->with('builder', $this)
            ->with('page', $page);
    }

    public function buildBlock(Block $block): View
    {
        return $this
            ->getView('blocks.' . $block->name())
            ->with('block', $block);
    }

    private function getView($name): View
    {
        return $this->factory->make($this->theme['name'] . '::' . $name);
    }
}