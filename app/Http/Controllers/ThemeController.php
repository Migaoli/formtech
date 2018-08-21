<?php

namespace App\Http\Controllers;

class ThemeController extends Controller
{

    public function index()
    {
        return response()->json(config('cms.theme'));
    }
}
