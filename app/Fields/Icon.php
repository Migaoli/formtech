<?php


namespace App\Fields;


class Icon extends Field
{
    private $icons;


    public function icons(array $icons): self
    {
        $this->icons = $icons;

        return $this;
    }

    protected function getDefaultRules()
    {
        return [];
    }

    protected function append(): array
    {
        return [
            'icons' => $this->icons,
        ];
    }




}