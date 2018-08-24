<?php

namespace Tests\Unit;

use App\Fields\Collection;
use App\Fields\Text;
use Tests\TestCase;

class CollectionFieldTest extends TestCase
{

    /** @test */
    public function asd()
    {
        $field = Collection::make("test")
            ->of([Text::make('name')]);

        $rules = $field->toArray();

        dd($field->createValidationRules());

    }
}
