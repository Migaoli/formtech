<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Blocks\Block;
use App\Pages\Builder\StandardPageBuilder;
use App\Pages\PageBuilder;

class BlockPreviewController extends Controller
{

    /**
     * @var StandardPageBuilder
     */
    private $pageBuilder;

    public function __construct(StandardPageBuilder $pageBuilder)
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
