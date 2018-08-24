<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTes extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_upload_image()
    {
        $this->actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();

        Storage::fake('media');

        $image1 = UploadedFile::fake()->image('test.jpg');
        $image2 = UploadedFile::fake()->image('test.jpg');

        $payload = ['images' => [$image1, $image2]];

        $response = $this->json('post', 'api/images', $payload);


        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id', 'type', 'file_path', 'name', 'mime_type'
                ]
            ]);


    }
}
