<?php


namespace App\Blocks\Text;


use App\Blocks\Block;
use App\Blocks\RequestHandler;
use Illuminate\Http\Request;

class TextImageRequestHandler implements RequestHandler
{

    public function get($id): Block
    {
        // TODO: Implement get() method.
    }

    public function create(Request $request): Block
    {
        $gallery = new TextImageBlock($request->only('data'));

        $gallery->save();

        $gallery->updateImages($request->get('images', []));


        return $gallery;
    }

    public function update(Block $block, Request $request): Block
    {
        /** @var TextImageBlock $block */
        $block->fill($request->only('data'));

        $block->updateImages($request->get('images', []));

        $block->save();

        return $block;
    }

    public function delete(Block $block, Request $request): void
    {

        /** @var TextImageBlock $block */
        $block->images()->delete();

        $block->delete();
    }
}