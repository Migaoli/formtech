<?php


namespace App\Pages;


use Illuminate\Support\Str;

class PageServiceImpl implements PageService
{

    private $types = [];

    public function register($page): PageService
    {
        if (!class_exists($page)) {
            throw new \InvalidArgumentException("Could not register page. Class ${page} not found.");
        }

        if (!is_subclass_of($page, Page::class)) {
            throw new \InvalidArgumentException("Could not register page. ${$page} must extend the Page class");
        }

        $name = str_replace('\\', '', Str::snake(class_basename($page)));

        if ($this->isRegistered($name)) {
            throw new \InvalidArgumentException("Page with ${name} is already registered.");
        }

        $this->types[$name] = $page;

        return $this;
    }

    public function registered(): array
    {
        return $this->types;
    }

    public function isRegistered(string $name): bool
    {
        return array_key_exists($name, $this->types);
    }

    public function getType(string $name): string
    {
        return array_get($this->types, $name, null);
    }

    public function hasType(string $type): bool
    {
        return array_search($type, $this->types, true);
    }

    public function getMetaData(string $name): array
    {
        $type = $this->getType($name);
        $page = new $type();

        return [
            'name' => $name,
            'type' => $type,
            'fields' => $page->fields(),
        ];
    }


}