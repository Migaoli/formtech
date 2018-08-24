<?php

namespace App\Http\Controllers;

use App\Media\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{

    private $manager;

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    public function get(Request $request)
    {
        $id = $request->query('id');

        $media = Media::findOrFail($id);

        $path = \Storage::disk('media')->get($media->file_path);

        $image =  $this->manager->make($path);

        if ($request->query->has('thumb')) {
            $image = $image->fit(200);
        }

        return $image->response();
    }

    public function post(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'required|mimes:jpg,jpeg,png,bmp|max:8000'
        ]);

        $response = [];

        /** @var UploadedFile $image */
        $images = $request->file('images');
        foreach ($images as $image) {
            $path = $image->store('images', 'media');

            $media = new Media([
                'type' => 'image',
                'file_path' => $path,
                'name' => $image->getFilename(),
                'mime_type' => $image->getMimeType()
            ]);

            $media->save();

            $response[] = $media;
        }

        return response()->json($response);
    }
}
