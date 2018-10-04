<?php


namespace App\Pages;


use App\Fields\Select;

class ErrorPage extends Page
{
    public function fields(): array
    {
        return array_merge(parent::fields(), [
            Select::make('Error Type', 'data.error_type')
                ->options([
                    '404' => 'Page not found',
                    '500' => 'Random Error',
                ])
                ->defaultTo('normal'),

            Select::make('Template', 'data.template')
                ->options(config('cms.theme.templates')),
        ]);
    }
}