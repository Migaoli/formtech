<?php


namespace App\Blocks\Parser;


use Illuminate\Contracts\Support\Htmlable;

abstract class BlockParser implements Htmlable
{
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