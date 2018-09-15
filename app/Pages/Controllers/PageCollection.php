<?php


namespace App\Pages\Controllers;


use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($page) {
           return [
               'id' => $page->id,
               'parent_id' => $page->parent_id,
               'order' => $page->order,
               'published' => $page->published,
               'in_menu' => $page->in_menu,
               'title' => $page->title,
               'slug' => $page->slug,
               'type' => $page->type,
               'created_at' => $page->created_at,
               'updated_at' => $page->updated_at,
               'live_version' => null,
           ];
        });
    }


}