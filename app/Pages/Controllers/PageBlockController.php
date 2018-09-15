<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Blocks\Block;
use App\Pages\Blocks\Blocks;
use App\Pages\Blocks\Rules\ValidBlockType;
use App\Pages\StandardPage;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageBlockController extends Controller
{
    private $blocks;

    private $rules;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Blocks $blocks, Connection $connection)
    {
        $this->blocks = $blocks;
        $this->connection = $connection;

        $this->rules = [
            'name' => ['required', new ValidBlockType($this->blocks)],
            'container' => ['required', 'string'],
            'order' => ['integer'],
        ];
    }

    public function index($pageId)
    {
        $page = StandardPage::with('blocks')->findOrFail($pageId);

        return response()->json($page->blocks);
    }

    public function get($pageId, $id)
    {
        $block = Block::query()->where("page_id", $pageId)->findOrFail($id);

        return response()->json($block);
    }

    /**
     * @param $pageId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create($pageId, Request $request)
    {
        $page = StandardPage::findOrFail($pageId);

        $request->validate($this->rules);

        $blockName = $request->get('name');

        $blockRules = $this->blocks->getRules($blockName);

        $request->validate($blockRules);

        $handler = $this->blocks->createHandler($blockName);

        $this->connection->beginTransaction();

        try {
            $block = $handler->create($request);

            $block->container = $request->get('container');
            $block->order = $request->get('order', 0);

            $page->addBlock($block);

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            throw $e;
        }

        return response()->json($block, 201);
    }

    /**
     * @param $pageId
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update($pageId, $id, Request $request)
    {
        $block = Block::findOrFail($id);

        $request->validate($block->rules());

        $handler = app()->make($block::handler());

        $this->connection->beginTransaction();

        try {
            $handler->update($block, $request);

            $block->save();

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }

        return response()->json([], 204);
    }

    public function delete($pageId, $id, Request $request)
    {
        $block = Block::where('page_id', $pageId)->findOrFail($id);

        $handler = app()->make($block::handler());

        $handler->delete($block, $request);

        return response()->json([], 204);
    }

    public function updateOrder($pageId, Request $request)
    {
        $payload = $request->validate([
            '*.id' => 'required|integer',
            '*.container' => 'required|string',
            '*.order' => 'required|integer'
        ]);

        DB::transaction(function () use ($payload, $pageId) {
            foreach ($payload as $block) {
                DB::table('blocks')
                    ->where([
                        ['page_id', $pageId],
                        ['id', $block['id']]
                    ])
                    ->update([
                        'order' => $block['order'],
                        'container' => $block['container'],
                    ]);
            }
        });

        return response()->json([], 204);
    }


}
