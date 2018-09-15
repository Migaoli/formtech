<?php


namespace App\Pages\Controllers;


use App\Pages\Page;
use Illuminate\Http\Resources\Json\Resource;

class PageResource extends Resource
{
    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {
        parent::__construct($page);
        $this->page = $page;
    }

    public function toArray($request)
    {
        return $this->page->toArray();
    }

    public function with($request)
    {
        return [
            'meta' => [
                'fields' => $this->page->fields(),
            ]
        ];
    }


}