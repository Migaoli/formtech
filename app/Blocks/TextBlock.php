<?php


namespace App\Blocks;


use App\Fields\Select;
use App\Fields\Text;

class TextBlock extends Block
{

    public function fields(): array
    {
        return [
            Text::make('Heading'),
            Select::make('Heading alignment'),
            Select::make('Heading type'),
        ];
    }

    public function template(): string
    {
        return 'test';
    }


}