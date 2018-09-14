<?php


namespace App\Blocks\Text;


use App\Blocks\Parser;
use Illuminate\Support\Str;
use Spatie\Html\BaseElement;
use Spatie\Html\Elements\Div;
use Spatie\Html\Elements\Img;
use Spatie\Html\Elements\Span;

class TextImageParser extends Parser
{

    public function toHtml()
    {
        $content = $this->createContent();
        $images = $this->createImages();

        $el = Div::create()
            ->id("block-{$this->block->id}")
            ->addClass([
                'block-container',
                Str::kebab(Str::studly($this->block->name())),
            ])
            ->addChild($this->createHeader());

        if ($this->imagesInlined()) {
            $el = $el->addChild($content->prependChild($images));
        }

        return $el;
    }

    private function getAlignmentClass()
    {
        $alignment = $this->block->alignment();

        if ($alignment === 'right') {
            return 'text-right';
        }

        if ($alignment === 'center') {
            return 'text-center';
        }

        return '';
    }

    private function createHeader(): BaseElement
    {
        $heading = $this->block->heading();
        $type = $this->block->headingType();

        $div = Div::create()
            ->class([
                'header',
                $this->getAlignmentClass(),
            ]);

        if ($type === 'normal') {
            $div = $div->addChild(Span::create()->text($heading));
        } else if ($type === 'hidden') {

        } else {
            $div = $div->addChild(html()->element($type)->text($heading));
        }

        return $div;
    }

    private function createContent(): BaseElement
    {
        return Div::create()
            ->class([
                'content',
                $this->getAlignmentClass(),
                $this->imagesInlined() ? 'inline' : '',
            ])
            ->text($this->block->content());
    }

    private function createImages(): BaseElement
    {

        $images = $this->block->images
            ->map(function ($image) {
                return Div::create()
                    ->class([
                        "w-1/{$this->block->getData('image_columns')}",
                        'px-3',
                    ])
                    ->addChild(Img::create()->src($image->url()));
            });

        $el = Div::create()
            ->class([
                $this->imagesInlined() ? 'inline-flex w-1/2' : 'flex',
                'flex-wrap',
                '-mx-3',
            ])
            ->addChildren($images->toArray());

        if ($this->imagesInlined()) {
            $el = $el->addClass(Str::contains($this->block->imagePosition(), 'left') ?
                'float-left' :
                'float-right');
        }


        return $el;
    }

    private function imagesInlined(): bool
    {
        return Str::startsWith($this->block->imagePosition(), 'inline');
    }

    private function imagesBeside(): bool
    {
        return Str::contains($this->block->imagePosition(), ['left', 'right']);
    }


}