<?php


namespace App\Fields;


class Row extends Field
{
    /**
     * @var array
     */
    private $children;

    public function __construct(array $children)
    {
        parent::__construct('');

        $this->children = $children;
    }

    protected function append(): array
    {
        return array_merge(parent::append(), [
            'children' => $this->children,
        ]);
    }


    public function createValidationRules(): array
    {
        return collect($this->children)
            ->flatMap(function ($field) {
                return $field->createValidationRules();
            })
            ->toArray();
    }
}