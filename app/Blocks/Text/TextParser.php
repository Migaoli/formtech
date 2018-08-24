<?php


namespace App\Blocks\Text;

use App\Blocks\Parser;
use Illuminate\Support\Str;
use Spatie\Html\BaseElement;
use Spatie\Html\Elements\Div;
use Spatie\Html\Elements\Span;

class TextParser extends Parser
{


    public function toHtml()
    {
        return Div::create()
            ->id("block-{$this->block->id}")
            ->addClass([
                'block-container',
                Str::kebab(Str::studly($this->block->name())),
            ])
            ->addChild($this->createHeader())
            ->addChild($this->createContent())
            ->render();
    }

    private function getAlignmentClass()
    {
        $alignment = $this->block->data('alignment');

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
        $heading = $this->block->data('heading');
        $type = $this->block->data('heading_type');

        $div = Div::create()
            ->class([
                'header',
                $this->getAlignmentClass()
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
            ])
            ->text($this->block->data('content'));
    }

}