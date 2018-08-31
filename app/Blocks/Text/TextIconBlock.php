<?php


namespace App\Blocks\Text;


use App\Blocks\Block;
use App\Fields\Color;
use App\Fields\Icon;
use App\Fields\Markdown;
use App\Fields\Panel;
use App\Fields\Row;
use App\Fields\Select;
use App\Fields\Text;

class TextIconBlock extends Block
{
    public function fields(): array
    {
        return [
            new Panel('Text', [
                new Row([
                    Text::make('Heading', 'data.heading')
                        ->rules([
                            'required',
                            'string',
                            'max:100',
                        ]),

                    Select::make('Heading type', 'data.heading_type')
                        ->options([
                            'h1' => 'Heading 1',
                            'h2' => 'Heading 2',
                            'h3' => 'Heading 3',
                            'h4' => 'Heading 4',
                            'h5' => 'Heading 5',
                            'normal' => 'Normal',
                            'hidden' => 'Hidden',
                        ])
                        ->defaultTo('h1'),

                    Select::make('Alignment', 'data.alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right'
                        ])
                        ->defaultTo('left'),
                ]),

                Markdown::make('Content', 'data.content'),
            ]),

            new Panel('Icon', [
                Icon::make('Icon', 'data.icon')
                    ->rules(['required']),

                Color::make('Color', 'data.icon_color')
                    ->rules(['required'])
                    ->defaultTo('#000'),

                Select::make('Image position', 'data.image_position')
                    ->options([
                        'above_center' => 'Above, centered',
                        'below_center' => 'Below, centered',
                        'beside_left' => 'Beside, left',
                        'beside_right' => 'Beside, right',
                    ])
                    ->defaultTo('above_center'),
            ]),


        ];
    }


}