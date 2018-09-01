<?php

namespace Tests\Feature\Blocks;

use App\Blocks\Text\TextBlock;
use App\Pages\StandardPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextBlockTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    private function createValidPayload()
    {
        return [
            'name' => 'text_block',
            'container' => 'c1',
            'data' => [
                'heading' => 'this is a heading',
                'heading_type' => 'h3',
                'alignment' => 'left',
                'content' => 'this is some random text'
            ],
        ];
    }

    /** @test */
    public function can_get_text_block_by_id()
    {
        $page = factory(StandardPage::class)->create();

        /** @var TextBlock $block */
        $block = factory(TextBlock::class)->create(['page_id' => $page->id]);

        $this->json('get', "api/pages/{$page->id}/blocks/{$block->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'page_id',
                'container',
                'data' => [
                    'heading',
                    'heading_type',
                    'alignment',
                    'content'
                ],
                'order',
                'created_at',
                'updated_at',
            ])
            ->assertJson($block->toArray());
    }

    /** @test */
    public function user_can_create_a_new_text_block()
    {
        $page = factory(StandardPage::class)->create();

        $payload = $this->createValidPayload();

        $this->withoutExceptionHandling();

        $response = $this
            ->json('post', "api/pages/$page->id/blocks", $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'page_id',
                'container',
                'data' => [
                    'heading',
                    'heading_type',
                    'alignment',
                    'content'
                ],
                'order',
                'created_at',
                'updated_at',
            ]);

        $id = $response->json('id');

        $block = TextBlock::find($id);

        $this->assertNotNull($block);
        $this->assertEquals($page->id, $block->page_id);
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

        $response = $this->json('post', "api/pages/{$page->id}/blocks", $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [$key]
            ]);
    }

    /** @test */
    public function user_can_update_text_block()
    {
        $page = factory(StandardPage::class)->create();

        /** @var TextBlock $block */
        $block = factory(TextBlock::class)->create(['page_id' => $page->id]);

        $payload = [
            'data' => [
                'heading' => 'new heading',
                'heading_type' => 'hidden',
                'alignment' => 'right',
                'content' => 'new content',
            ],
        ];

        $this->json('put', "api/pages/{$page->id}/blocks/{$block->id}", $payload)
            ->assertStatus(204);

        $block->refresh();

        $this->assertEquals($payload['data']['heading'], $block->getData('heading'));
        $this->assertEquals($payload['data']['heading_type'], $block->getData('heading_type'));
        $this->assertEquals($payload['data']['alignment'], $block->getData('alignment'));
        $this->assertEquals($payload['data']['content'], $block->getData('content'));
    }

    /**
     * @test
     * @dataProvider invalidDataProvider
     */
    public function update_fails_if_data_is_invalid($key, $value)
    {
        $page = factory(StandardPage::class)->create();
        $block = factory(TextBlock::class)->create(['page_id' => $page->id]);

        $payload = $block->toArray();
        array_set($payload, $key, $value);

        $this->json('put', "api/pages/{$page->id}/blocks/{$block->id}", $payload)
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
            'heading type is required' => ['data.heading_type', null],
            'heading type must be valid' => ['data.heading_type', 'invalid'],
            'alignment is required' => ['data.alignment', null],
            'alignment must be valid' => ['data.alignment', 'invalid'],
            'content must be string' => ['data.content', false]
        ];
    }
}
