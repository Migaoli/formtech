<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Builder\StandardPageBuilder;
use App\Pages\Page;
use App\Pages\PageBuilder;
use Illuminate\View\Factory;

class PagePreviewController extends Controller
{


    /**
     * @var PageBuilder
     */
    private $factoy;

    public function __construct(Factory $factoy)
    {
        $this->factoy = $factoy;
    }

    public function get($id)
    {
        $page = Page::findOrFail($id);


        return (new StandardPageBuilder($this->factoy))->build($page);
    }

    public function build($id) {

    }
}
