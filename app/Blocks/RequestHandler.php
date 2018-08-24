<?php


namespace App\Blocks;


use Illuminate\Http\Request;

interface RequestHandler
{
    public function get($id): Block;

    public function create(Request $request): Block;

    public function update(Block $block, Request $request): Block;

    public function delete(Block $block, Request $request): void;
}