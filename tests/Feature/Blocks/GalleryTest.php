<?php

namespace Tests\Feature\Blocks;

use App\Blocks\Gallery\GalleryBlock;
use App\Media\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function add_image()
    {
        $gallery = new GalleryBlock();
        $gallery->save();
        $image = factory(Media::class)->state('image')->create();

        $gallery->images()->save($image);

        $this->assertDatabaseHas('media_references', ['media_id' => $image->id, 'model_id' => $gallery->id, 'model_type' => $gallery->type]);

        $size = $gallery->refresh()->images()->count();

        $this->assertEquals(1, $size);
    }
}
