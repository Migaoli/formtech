<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        dd(\Storage::disk('public')->allFiles());
    }
}
