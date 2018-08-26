<?php


namespace App\Pages;


use App\Blocks\Block;

class StandardPage extends Page
{

    protected $with = ['blocks'];

    public function addBlock(Block $block)
    {
        $this->blocks()->save($block);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'page_id');
    }
}