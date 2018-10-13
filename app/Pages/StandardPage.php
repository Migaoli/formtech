<?php


namespace App\Pages;


use App\Fields\Select;
use App\Pages\Blocks\Block;

class StandardPage extends Page
{
    public function layout(): string
    {
        return $this->getData('layout');
    }

    public function fields(): array
    {
        return array_merge(parent::fields(), [
            Select::make('Layout', 'data.layout')
                ->options($this->getLayouts())
                ->defaultTo('normal'),
        ]);
    }

    private function getLayouts(): array
    {
        return collect(config('cms.theme.layouts'))
            ->map(function ($layout) {
                return $layout['name'];
            })
            ->toArray();
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'page_id');
    }

    public function blocksInContainer($container)
    {
        return $this->blocks->filter(function ($block) use ($container) {
            return $block->container === $container;
        });
    }
}