<?php


namespace App\Fields;


use Illuminate\Validation\Rule;

class Select extends Field
{
    private $options;

    protected function getDefaultRules()
    {
        return ['required', Rule::in(array_keys($this->options))];
    }


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