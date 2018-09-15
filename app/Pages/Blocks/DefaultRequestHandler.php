<?php


namespace App\Pages\Blocks;


use Illuminate\Http\Request;

class DefaultRequestHandler implements RequestHandler
{
    private $blocks;

    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    public function get($id): Block
    {
        return Block::findOrFail($id);
    }

    public function create(Request $request): Block
    {
        $block = $this->blocks->create($request->get('name'), $request->only(['data']));

        $block->save();

        return $block;
    }

    public function update(Block $block, Request $request): Block
    {
        $block->fill($request->only('data'));

        $block->save();

        return $block;
    }

    public function delete(Block $block, Request $request): void
    {
        $block->delete();
    }

}