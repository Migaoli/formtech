<?php


namespace App\Pages\Blocks;


use App\Fields\Markdown;
use App\Fields\Select;

class MarkdownBlock extends Block
{
    public function fields(): array
    {
        return [
            Select::make('Alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'justify' => 'Justify',
                    'right' => 'Right',
                ])->defaultTo('left'),

            Markdown::make('Content'),
        ];
    }

}