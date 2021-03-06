<?php


namespace App\Pages\Blocks\Gallery;


use App\Fields\Markdown;
use App\Fields\Media as MediaField;
use App\Fields\Text;
use App\Media\MediaReference;
use App\Pages\Blocks\Block;

class GalleryBlock extends Block
{
    protected $with = ['images'];

    public static function handler(): string
    {
        return RequestHandler::class;
    }

    public function fields(): array
    {
        return [
            Text::make('heading', 'data.heading')
                ->rules([
                    'required',
                    'max:100'
                ]),

            Markdown::make('description', 'data.description'),

            MediaField::make('images', 'images')
                ->allowMultiple()
                ->defaultTo([])
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