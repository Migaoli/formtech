<?php


namespace App\Fields;


class Slug extends Field
{
    protected function getDefaultRules()
    {
        return ['string', 'alpha_dash'];
    }
}