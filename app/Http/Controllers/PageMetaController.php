<?php

namespace App\Http\Controllers;

use App\Pages\PageService;

class PageMetaController extends Controller
{
    /**
     * @var PageService
     */
    private $pages;

    public function __construct(PageService $pages)
    {
        $this->pages = $pages;
    }


    public function index()
    {
        $meta = collect($this->pages->registered())
            ->map(function ($type, $name) {
                return $this->pages->getMetaData($name);
            })
            ->keyBy('name');

        return response()->json($meta);
    }
}
