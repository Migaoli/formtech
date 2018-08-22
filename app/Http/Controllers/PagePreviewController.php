<?php

namespace App\Http\Controllers;

use App\Builder\PageBuilder;
use App\Page;

class PagePreviewController extends Controller
{


    /**
     * @var PageBuilder
     */
    private $builder;

    public function __construct(PageBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function get($id)
    {
        $page = Page::findOrFail($id);

        return $this->builder->build($page);
    }
}
