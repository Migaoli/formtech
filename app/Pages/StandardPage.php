<?php


namespace App\Pages;


use App\Blocks\Block;
use App\Fields\Select;

class StandardPage extends Page
{

    protected $with = ['blocks'];


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


    public function addBlock(Block $block)
    {
        $this->blocks()->save($block);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'page_id');
    }
}