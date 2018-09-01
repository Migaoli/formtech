<?php


namespace App\Pages;


interface PageService
{
    public function register($page): self;

    public function registered(): array;

    public function isRegistered(string $name): bool;

    public function getType(string $name): string;

    public function hasType(string $type): bool;

    public function getMetaData(string $name): array;
}