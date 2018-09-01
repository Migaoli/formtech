<?php


namespace App\Fields;


class TextWithSlug extends Field
{

    private $slugField;

    protected function getDefaultRules()
    {
        return ['string'];
    }

    public function slug(string $key): self
    {
        $this->slugField = $key;
        return $this;
    }

    protected function append(): array
    {
        return [
            'slugField' => $this->slugField,
        ];
    }


}