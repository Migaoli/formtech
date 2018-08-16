<?php


namespace App\Validation;


use Illuminate\Database\Eloquent\Model;

class ValidatableModel extends Model implements Validatable
{
    use Validates;

    protected $rules = [];

    protected function getData(): array
    {
        return $this->getAttributes();
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $options
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(array $options = [])
    {
        $this->validate();
        return parent::save($options); // TODO: Change the autogenerated stub
    }


}