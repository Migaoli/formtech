<?php


namespace App\Blocks\Text;


use App\Blocks\Block;
use App\Fields\Markdown;
use App\Fields\Media;
use App\Fields\Panel;
use App\Fields\Select;
use App\Fields\Text;
use App\Media\MediaReference;

class TextImageBlock extends Block
{
    protected $with = ['images'];

    public static function handler(): string
    {
        return TextImageRequestHandler::class;
    }

    public function fields(): array
    {
        return [
            new Panel('Text', [
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

                Markdown::make('Content', 'data.content'),
            ]),

            new Panel('Images', [
                Select::make('Image position', 'data.image_position')
                    ->options([
                        'above_center' => 'Above, centered',
                        'below_center' => 'Below, centered',
                        'beside_left' => 'Beside, left',
                        'beside_right' => 'Beside, right',
                        'inline_left' => 'inline, left',
                        'inline_right' => 'inline, right',
                    ])
                    ->defaultTo('above_center'),

                Select::make('Image columns', 'data.image_columns')
                    ->options([
                        '1' => 'One column',
                        '2' => 'Two columns',
                        '3' => 'Three columns',
                        '4' => 'Four columns',
                        '5' => 'Five columns',
                        '6' => 'Six columns',
                    ])
                    ->defaultTo('1'),

                Media::make('Images', 'images')
                    ->allowMultiple()
                    ->defaultTo([]),
            ]),
        ];
    }


    public function images()
    {
        return $this->morphMany(MediaReference::class, 'model');
    }

    public function updateImages($newImages)
    {
        $this->images
            ->reject(function (MediaReference $currentImage) use ($newImages) {
                return \in_array($currentImage->id, array_column($newImages, 'id'), true);
            })
            ->each
            ->delete();


        collect($newImages)
            ->each(function ($image) {
                static $order = 0;

                $id = $image['id'];
                if (\is_string($id)) {
                    $this->images()->save(new MediaReference([
                        'order' => $order,
                        'media_id' => $image['media']['id']
                    ]));
                } else {
                    $ref = MediaReference::findOrFail($id);
                    $ref->order = $order;
                }

                $order++;
            });
    }
}