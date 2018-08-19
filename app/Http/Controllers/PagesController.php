<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index(Request $request)
    {
        if ($request->query->has('tree')) {
            return Page::tree();
        }

        return Page::all();
    }


    public function get($id)
    {
        $page = Page::findOrFail($id);

        return response()->json($page);
    }

    public function create(Request $request)
    {
        $payload = $request->only(['title', 'slug', 'settings']);

        $page = Page::create($payload);

        return response()->json($page, 201);
    }

    public function update($id, Request $request)
    {

        $page = Page::findOrFail($id);


        $payload = $request->validate($page->rules());


        $page->fill($payload);

        $page->save();

        return response()->json([], 204);
    }
}
