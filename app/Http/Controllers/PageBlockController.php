<?php

namespace App\Http\Controllers;

use App\Blocks\Blocks;
use App\Page;
use Illuminate\Http\Request;

class PageBlockController extends Controller
{
    private $blocks;

    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    public function create($pageId, Request $request)
    {
        $page = Page::findOrFail($pageId);

        $name = $request->input('name');
        abort_if(!$this->blocks->isRegistered($name), 400);

        $block = $this->blocks->create(
            $name,
            $request->only('data')
        );

        $page->addBlock($block);

        return response()->json($block, 201);


    }


}
