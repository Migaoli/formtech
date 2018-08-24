<?php


namespace App\Fields;


class Collection extends Field
{

    private $fields = [];

    public function of(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function createValidationRules(): array
    {
        $own = parent::createValidationRules();

        $fieldRules = collect($this->fields)
            ->mapWithKeys(function ($field) {
                return ["{$this->key()}.*.{$field->key()}" => $field->rules()];
            })
            ->toArray();

        return array_merge($own, $fieldRules);
    }

    protected function append(): array
    {
        return [
            'fields' => array_map(function ($field) {
                return $field->toArray();
            }, $this->fields)
        ];
    }
}