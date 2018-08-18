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
    protected $defaultRules = [];

    private function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->key = $key ?? Str::slug($name, '_');
    }

    public static function make($name, $key = null)
    {
        return new static($name, $key);
    }

    public function type(): string
    {
        if ($this->type !== null) {
            return $this->type;
        }

        return str_replace(
            '\\', '', Str::snake(class_basename($this))
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function rules(): array
    {
        return array_merge($this->rules, $this->defaultRules);
    }

    public function setRules($rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    public function createValidationRules(): array
    {
        return [$this->key => $this->rules()];
    }

    protected function append(): array
    {
        return [];
    }

    public function toArray()
    {
        $data = [
            'type' => $this->type(),
            'name' => $this->name(),
            'key' => $this->key(),
            'rules' => $this->rules(),
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