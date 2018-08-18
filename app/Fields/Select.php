<?php


namespace App\Fields;


class Select extends Field
{
    private $options;

    public function options(array $options = []): Select
    {
        $this->options = $options;

        return $this;
    }

    protected function append(): array
    {
        return ['options' => $this->options];
    }


}