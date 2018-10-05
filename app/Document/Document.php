<?php


namespace App\Document;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Ramsey\Uuid\Uuid;

abstract class Document implements Arrayable, Jsonable, \JsonSerializable
{
    private $id;

    private $attributes;

    abstract public function documentType(): string;

    abstract public function schema(): Schema;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function fromStorage($id, $attributes): void
    {
        $doc = new static();
        $doc->attributes = $attributes;
        $doc->id = $id;
    }

    public function implementationClass(): string
    {
        return static::class;
    }

    public function id(): string
    {
        $this->ensureId();
        return $this->id;
    }

    private function ensureId()
    {
        if ($this->id === null) {
            $this->id = Uuid::uuid1()->toString();
        }
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    public function set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function has($key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    public function fill($attributes)
    {
        $this->attributes = $this->schema()->filter($attributes);
    }

    public function supplements(): array
    {
        return [];
    }

    public function toArray()
    {
        return array_merge(
            ['id' => $this->id],
            $this->attributes,
            $this->supplements()
        );
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize()
    {
        $this->toArray();
    }


}