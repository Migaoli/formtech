<?php


namespace App\Blocks\Gallery;


use App\Blocks\Block;
use App\Fields\Collection;
use App\Fields\Select;
use App\Fields\Text;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class GalleryBlock extends Block implements HasMedia
{

    use HasMediaTrait;


    public static function handler(): string
    {
        return RequestHandler::class;
    }


    public function fields(): array
    {
        return [
            Collection::make('Images')
                ->of([
                    Text::make('name')->setRules(['required']),
                    Select::make("test")->options(['one' => 'ONE', 'two' => 'TWO']),
                ]),
        ];
    }


}