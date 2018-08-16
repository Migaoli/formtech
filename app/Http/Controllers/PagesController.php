<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{

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
}
