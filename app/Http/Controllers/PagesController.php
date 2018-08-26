<?php

namespace App\Http\Controllers;

use App\Pages\MenuSeparator;
use App\Pages\Page;
use App\Pages\StandardPage;
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
        $payload = $request->validate([
            'type' => 'required|in:standard,menu_separator',
            'title' => 'required|string',
            'slug' => ['required', 'alpha_dash',],
        ]);

        $page = null;

        switch ($payload['type']) {
            case 'standard':
                $page = StandardPage::create($payload);
                break;
            case 'menu_separator':
                $page = MenuSeparator::create($payload);
                break;
        }

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
