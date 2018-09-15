<?php


namespace App\Pages\Blocks\Gallery;


use App\Pages\Blocks\Parser;

class GalleryParser extends Parser
{
    /*public function toHtml()
    {
        return Div::create()
            ->id("block-{$this->block->id}")
            ->addClass([
                'block-container',
                Str::kebab(Str::studly($this->block->name())),
            ])
            ->addChild($this->createHeader())
            ->addChild($this->createGallery())
            ->addChild($this->createDescription())
            ->render();
    }

    private function createHeader(): BaseElement
    {
        return Div::create()
            ->addClass(['header'])
            ->text($this->block->getData('heading'));
    }

    private function createGallery(): BaseElement
    {
        return Div::create()
            ->addClass([
                'gallery-wrapper'
            ])
            ->addChildren(
                $this->block->images
                ->map(function ($image) {
                    return Img::create()->src("/api/im")
                })
            )
    }

    private function createDescription(): BaseElement
    {
    }*/


}