<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;

class ImageController extends Controller
{


    private $manager;

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    public function get()
    {
        $path = storage_path('app/public/test.jpg');

        return $this->manager->make($path)->crop(400, 400)->response();
    }

    public function post()
    {

    }
}
