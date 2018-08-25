<?php


namespace App\Fields;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;

class Field implements Jsonable, Arrayable, \JsonSerializable
{
    private $type;
    private $name;
    private $key;
    private $rules = [];
    private $default;

    private function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->key = $key ?? Str::slug($name, '_');
    }

    public static function make($name, $key = null)
    {
        return new static($name, $key);
    }

    public function getType(): string
    {
        if ($this->type !== null) {
            return $this->type;
        }

        return str_replace(
            '\\', '', Str::snake(class_basename($this))
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function defaultTo($value): self
    {
        $this->default = $value;

        return $this;
    }

    protected function getDefaultRules()
    {
        return [];
    }

    public function getRules(): array
    {
        return array_merge($this->rules, $this->getDefaultRules());
    }

    public function rules($rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    public function createValidationRules(): array
    {
        return [$this->key => $this->getRules()];
    }

    protected function append(): array
    {
        return [];
    }

    public function toArray()
    {
        $data = [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'key' => $this->getKey(),
            'default' => $this->getDefault(),
            'rules' => $this->getRules(),
            'createRules' => [],
            'updateRules' => [],
        ];

        return array_merge($data, $this->append());
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(json_last_error_msg());
        }

        return $json;
    }


}