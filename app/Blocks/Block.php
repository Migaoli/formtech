<?php


namespace App\Blocks;


use App\Fields\Field;
use App\Validation\Validatable;
use Illuminate\Container\Container;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class Block extends \Eloquent implements Validatable
{
    protected $table = 'blocks';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

    private $validator;

    public function fields(): array
    {
        return [];
    }

    public function template(): string
    {
        return '';
    }

    public function data(string $key = null, $default = null)
    {
        $data = $this->getAttribute('data');

        if ($key === null) {
            return $data;
        }

        return data_get($data, $key, $default);
    }

    private function getValidator(): Validator
    {
        if ($this->validator === null) {
            $this->validator = Container::getInstance()
                ->make(Factory::class)
                ->make(
                    $this->data(),
                    $this->createValidationRules()
                );
        }
        return $this->validator;
    }

    private function createValidationRules()
    {
        return collect($this->rules())
            ->flatMap(function (Field $field) {
                return $field->createValidationRules();
            })
            ->toArray();
    }

    public function isValid(): bool
    {
        return !$this->isInvalid();
    }

    public function isInvalid(): bool
    {
        return $this->getValidator()->fails();
    }

    public function rules(): array
    {
        return static::$rules;
    }

    public function validate()
    {
        $validator = $this->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function errors(): MessageBag
    {
        return $this->getValidator()->errors();
    }


}