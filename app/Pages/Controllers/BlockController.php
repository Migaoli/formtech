<?php

namespace App\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Pages\Blocks\Blocks;

class BlockController extends Controller
{
    private $blocks;


    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    public function index()
    {
        $blockMetaData = collect($this->blocks->registeredBlocks())
            ->map(function($type, $name) {
                return $this->blocks->getMetaData($name);
            })
            ->keyBy('name');

        return response()->json($blockMetaData);
    }

    public function get($name)
    {
        abort_if(!$this->blocks->isRegistered($name), 404);

        return response()->json($this->blocks->getMetaData($name));
    }
}
