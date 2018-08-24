<?php


namespace App\Blocks\Gallery;


use App\Blocks\Block;
use App\Fields\Markdown;
use App\Fields\Media as MediaField;
use App\Fields\Text;
use App\Media\Media;

class GalleryBlock extends Block
{
    /*public static function handler(): string
    {
        return RequestHandler::class;
    }*/

    public function fields(): array
    {
        return [
            Text::make('heading')->rules(['required']),
            Markdown::make('description'),
            MediaField::make('images')->allowMultiple()
        ];
    }

    public function images()
    {
        return $this->morphToMany(Media::class, 'model', 'media_references');
    }


}