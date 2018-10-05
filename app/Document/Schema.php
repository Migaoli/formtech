<?php


namespace App\Document;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Schema
{
    private $rules;

    private function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public static function create(array $rules): Schema
    {
        return new Schema($rules);
    }

    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(array $data)
    {
        $this->createValidator($data)->validate();
    }

    public function createValidator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, $this->rules);
    }

    public function filter(array $data): array
    {
        $result = [];

        $missingValue = Str::random(10);

        foreach (array_keys($this->rules) as $key) {
            $value = data_get($data, $key, $missingValue);

            if ($value !== $missingValue) {
                Arr::set($result, $key, $value);
            }
        }

        return $result;
    }


}