<?php


namespace App\Blocks;


interface Blocks
{
    /**
     * Register a block a new block type.
     * Type must be the fully qualified class name.
     * Any Block class mus implement the base @see Block class.
     *
     * Additionally a name can be provided for this block type.
     * By default the name will be the simple block class name in snake case.
     * E.g app/Blocks/TextBlock -> text_block
     *
     * @param string $type Fully qualified class name
     * @param string|null $name Associated name.
     * @return Blocks
     */
    public function register(string $type, string $name = null): self;

    /**
     * Get all registered blocks with their name as key and class name as value.
     *
     * @return array
     */
    public function registeredBlocks(): array;

    /**
     * Get the fully qualified class name by its name.
     * Returns null if there is no block registered to that name.
     *
     * @param $name
     * @return string|null
     */
    public function getBlockType($name): string;

    /**
     * Check if a block type is registered under the given name.
     *
     * @param $type
     * @return bool
     */
    public function hasType($type): bool;

    /**
     * Get the name by block class.
     *
     * @param $type
     * @return string
     */
    public function getName($type): string;

    /**
     * Check if an block type is registered under the given name.
     *
     * @param $name
     * @return bool
     */
    public function isRegistered($name): bool;

    /**
     * Create a new block instance.
     *
     * @param string $name
     * @param array $attributes
     * @return Block
     */
    public function create(string $name, array $attributes = []): Block;

    /**
     * Get meta information of a block type.
     *
     * @param $name
     * @return array
     */
    public function getMetaData($name): array;

    /**
     * Get rules for a block.
     *
     * @param $name
     * @return array
     */
    public function getRules($name): array;

    /**
     * Create a new request handler for a given block type.
     *
     * @param $name
     * @return RequestHandler
     */
    public function createHandler($name): RequestHandler;
}