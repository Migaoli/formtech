<?php

namespace App\Http\Controllers;

use App\Pages\MenuSeparator;
use App\Pages\Page;
use App\Pages\StandardPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'type' => 'required|in:standard_page,menu_separator',
            'title' => 'required|string',
            'slug' => ['required', 'alpha_dash',],
            'in_menu' => ['required', 'boolean'],
            'published' => ['required', 'boolean'],
            'data' => [],
        ]);

        $page = null;

        switch ($payload['type']) {
            case 'standard_page':
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

    public function updateOrder(Request $request)
    {
        $payload = $request->validate([
            '*.id' => 'required|integer',
            '*.parent_id' => '',
            '*.order' => 'required|integer',
        ]);

        DB::transaction(function () use ($payload) {
            foreach ($payload as $page) {
                DB::table('pages')
                    ->where([
                        ['id', $page['id']]
                    ])
                    ->update([
                        'order' => $page['order'],
                        'parent_id' => $page['parent_id'],
                    ]);
            }
        });

        return response()->json([], 204);


    }
}
