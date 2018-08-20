<?php


namespace App\Blocks;


use App\Fields\Markdown;
use App\Fields\Select;
use App\Fields\Text;

class TextBlock extends Block
{

    public function fields(): array
    {
        return [
            Text::make('Heading'),

            Select::make('Heading alignment')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right'
                ]),

            Select::make('Heading type')
                ->options([
                    'h1' => 'Heading 1',
                    'h2' => 'Heading 2',
                    'h3' => 'Heading 3',
                    'h4' => 'Heading 4',
                    'h5' => 'Heading 5',
                    'normal' => 'Normal',
                    'hidden' => 'Hidden',
                ]),

            Markdown::make('Content'),
        ];
    }

    public function template(): string
    {
        return 'test';
    }


}