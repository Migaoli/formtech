<?php


namespace App\Blocks\Gallery;


use App\Blocks\Block;
use Illuminate\Http\Request;

class RequestHandler implements \App\Blocks\RequestHandler
{
    public function get($id): Block
    {
        // TODO: Implement get() method.
    }

    public function create(Request $request): Block
    {
        $gallery = new GalleryBlock($request->only('data'));

        $gallery->save();

        return $gallery;
    }

    public function update(Block $block, Request $request): Block
    {
        /** @var GalleryBlock $block */
        $block->fill($request->only('data'));

        $block->updateImages($request->get('images', []));

        $block->save();

        return $block;
    }

    public function delete(Block $block, Request $request): void
    {

        /** @var GalleryBlock $block */
        $block->images()->delete();

        $block->delete();
    }


}