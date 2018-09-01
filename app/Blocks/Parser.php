<?php


namespace App\Blocks;


use Illuminate\Contracts\Support\Htmlable;

abstract class Parser implements Htmlable
{
    /**
     * @var Block
     */
    protected $block;

    /**
     * BlockParser constructor.
     * @param $block
     */
    public function __construct($block)
    {
        $this->block = $block;
    }


}