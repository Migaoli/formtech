<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Blocks\Block;
use App\Pages\PageBuilder;

class BlockPreviewController extends Controller
{

    /**
     * @var PageBuilder
     */
    private $pageBuilder;

    public function __construct(PageBuilder $pageBuilder)
    {
        \Debugbar::disable();
        $this->pageBuilder = $pageBuilder;
    }

    public function show($pageId, $id)
    {
        $block = Block::findOrFail($id);

        return view('preview-template', ['preview' => $this->pageBuilder->buildBlock($block)]);
    }
}
