<?php


namespace App\Fields;


class Checkbox extends Field
{
    protected function getDefaultRules()
    {
        return ['boolean'];
    }

}