<?php


namespace App\Fields;


class Panel extends Field
{
    /**
     * @var array
     */
    private $children;

    public function __construct($name, array $children)
    {
        parent::__construct($name);

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
            });
    }


}
