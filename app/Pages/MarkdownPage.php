<?php


namespace App\Pages;


use App\Fields\Select;

class MarkdownPage extends Page
{
    public function fields(): array
    {
        return array_merge(parent::fields(), [
            Select::make('template')
                ->options(['test' => 'test'])
                ->defaultTo('test'),
        ]);
    }


}