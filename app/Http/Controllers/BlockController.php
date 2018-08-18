<?php

namespace App\Http\Controllers;

use App\Blocks\Blocks;

class BlockController extends Controller
{
    private $blocks;


    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    public function index()
    {
        return response()->json($this->blocks->registeredBlocks());
    }

    public function get($name)
    {
        abort_if(!$this->blocks->isRegistered($name), 404);

        return response()->json($this->blocks->getMetaData($name));
    }
}
