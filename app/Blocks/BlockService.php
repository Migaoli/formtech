<?php


namespace App\Blocks;


use Illuminate\Support\Str;

class BlockService implements Blocks
{
    private $blockTypes = [];

    public function __construct(array $blockTypes = [])
    {
        foreach ($blockTypes as $key => $value) {
            if (is_numeric($key)) {
                $this->register($value);
            } else {
                $this->register($key, $value);
            }
        }
    }

    public function register(string $blockClass, string $name = null): Blocks
    {
        if (!class_exists($blockClass)) {
            throw BlockException::of("Tried to register {$name} to an unknown class {$blockClass}");
        }

        if (!is_subclass_of($blockClass, Block::class)) {
            throw BlockException::of("Cannon register block with name \"{$name}\" to a class \"{$blockClass}\" that does not extend block.");
        }

        $name = $name ?? str_replace('\\', '', Str::snake(class_basename($blockClass)));

        if (array_key_exists($name, $this->blockTypes)) {
            throw BlockException::of(
                "Found duplicate block. {$name} is already registered to {$this->getType($name)}");
        }

        $this->blockTypes[$name] = $blockClass;

        return $this;
    }

    public function registeredBlocks(): array
    {
        return $this->blockTypes;
    }

    public function getBlockType($name): string
    {
        if ($this->isRegistered($name)) {
            return $this->blockTypes[$name];
        }

        return null;
    }

    public function hasType($type): bool
    {
        return $this->getName($type) !== false;
    }

    public function getName($type): string
    {
        return array_search($type, $this->blockTypes, true);
    }

    public function isRegistered($name): bool
    {
        return array_key_exists($name, $this->blockTypes);
    }

    public function create(string $name, array $attributes = []): Block
    {
        $type = $this->getBlockType($name);

        if ($type === null) {
            throw BlockException::of("Unknown block type {$name}");
        }

        $block = new $type($attributes);
        $block->type = $type;

        return $block;
    }

    public function getMetaData($name): array
    {
        $type = $this->getBlockType($name);

        if ($type === null) {
            throw BlockException::of('');
        }

        $block = new $type();

        return [
            'name' => $name,
            'type' => $type,
            'template' => $block->template(),
            'fields' => $block->fields(),
        ];
    }


}