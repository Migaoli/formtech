<?php

namespace App\Http\Controllers;

use App\Blocks\Block;
use App\Blocks\Blocks;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageBlockController extends Controller
{
    private $blocks;

    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    public function index($pageId)
    {
        $page = Page::with('blocks')->findOrFail($pageId);

        return response()->json($page->blocks);
    }

    public function get($pageId, $id)
    {
        $block = Block::query()->where("page_id", $pageId)->findOrFail($id);

        return response()->json($block);
    }

    public function create($pageId, Request $request)
    {
        $page = Page::findOrFail($pageId);

        $name = $request->input('name');
        abort_if(!$this->blocks->isRegistered($name), 400);

        $attributes = $request->only('data', 'container');
        $block = $this->blocks->create(
            $name,
            $attributes
        );

        $page->addBlock($block);

        return response()->json($block, 201);
    }

    public function update($pageId, $id, Request $request)
    {
        $block = Block::findOrFail($id);

        $block->fill($request->only('data'));

        $block->save();

        return response()->json([], 204);
    }

    public function updateOrder($pageId, Request $request)
    {
        $payload = $request->validate([
            '*.id' => 'required|integer',
            '*.container' => 'required|string',
            '*.position' => 'required|integer'
        ]);

        DB::transaction(function () use ($payload, $pageId) {
            foreach ($payload as $block) {
                DB::table('blocks')
                    ->where([
                        ['page_id', $pageId],
                        ['id', $block['id']]
                    ])
                    ->update([
                        'position' => $block['position'],
                        'container' => $block['container'],
                    ]);
            }
        });

        return response()->json([], 204);
    }


}
