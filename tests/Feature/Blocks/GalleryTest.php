<?php

namespace Tests\Feature\Blocks;

use App\Blocks\Gallery\GalleryBlock;
use App\Media\Media;
use App\Pages\StandardPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function createValidPayload($attributes = [])
    {
        $default = [
            'name' => 'gallery_block',
            'container' => 'c1',
            'data' => [
                'heading' => 'this is a heading',
                'description' => 'this is a description',
            ],
            'images' => []
        ];

        return array_merge_recursive($attributes, $default);
    }

    /** @test */
    public function user_can_create_gallery_block()
    {
        $page = factory(StandardPage::class)->create();
        $image = factory(Media::class)->state('image')->create();

        $payload = $this->createValidPayload([
            'images' => [
                [
                    'id' => 'newImg',
                    'media' => $image->toArray(),
                ]
            ],
        ]);

        $this->withoutExceptionHandling();

        $response = $this
            ->json('post', "api/pages/{$page->id}/blocks", $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'page_id',
                'container',
                'data' => [
                    'heading',
                    'description'
                ],
                'images' => [
                    '*' => [
                        'id',
                        'order',
                        'media'
                    ]
                ],
                'order',
                'created_at',
                'updated_at',
            ]);

        $id = $response->json('id');

        $block = GalleryBlock::find($id);

        $this->assertNotNull($block);
        $this->assertEquals($page->id, $block->page_id);
        $this->assertEquals(1, $block->images()->count());
    }

    /**
     * @test
     * @dataProvider invalidDataProvider
     */
    public function create_fails_if_data_is_invalid($key, $value)
    {
        $page = factory(StandardPage::class)->create();

        $payload = $this->createValidPayload();
        array_set($payload, $key, $value);

        $this->json('post', "api/pages/{$page->id}/blocks", $payload)
            ->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [$key]
            ]);
    }

    public function invalidDataProvider()
    {
        $this->setUpFaker();
        return [
            'heading is required' => ['data.heading', null],
            'heading may not be longer than 100 characters' => ['data.heading', $this->faker->text(500)],
            'heading must be string' => ['data.heading', false],
            'description must be string' => ['data.description', false],
        ];
    }
}
