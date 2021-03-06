<?php


namespace App\Pages\Blocks\Text;


use App\Fields\Markdown;
use App\Fields\Row;
use App\Fields\Select;
use App\Fields\Text;
use App\Pages\Blocks\Block;

/**
 * App\Blocks\Text\TextBlock
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property string $container
 * @property int $position
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereContainer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pages\Blocks\TextBlock whereUpdatedAt($value)
 */
class TextBlock extends Block
{

    public function fields(): array
    {
        return [
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
        ];
    }

    public function template(): string
    {
        return 'test';
    }

    public function heading()
    {
        return $this->getData('heading');
    }

    public function headingType()
    {
        return $this->getData('heading_type');
    }


}