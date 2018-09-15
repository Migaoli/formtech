<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Page;
use App\Pages\PageBuilder;

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
