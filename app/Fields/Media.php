<?php


namespace App\Fields;


class Media extends Field
{
    private $allowMultiple = false;
    private $max;
    private $imagesOnly = false;

    public function allowMultiple($max = null): self
    {
        $this->allowMultiple = true;
        $this->max = $max;
        return $this;
    }

    public function onlyImages(): self
    {
        $this->imagesOnly;
        return $this;
    }

    protected function getDefaultRules()
    {
        return [
            'array'
        ];
    }

    protected function append(): array
    {
        return [
            'allowMultiple' => $this->allowMultiple,
            'max' => $this->max,
            'imagesOnly' => $this->imagesOnly,
        ];
    }


}