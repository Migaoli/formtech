<?php

namespace Tests\Feature;

use App\Blocks\TextBlock;
use App\Page;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageBlockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Page
     */
    private $page;

    protected function setUp()
    {
        parent::setUp();

        $this->page = factory(Page::class)->create();
    }

    private function createValidBlock()
    {
        return [
            'name' => 'text_block',
            'data' => [
                'heading' => 'test',
                'heading_alignment' => 'left',
                'heading_type' => 'h1'
            ],
        ];
    }

    /** @test */
    public function user_can_create_a_new_block()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $payload = $this->createValidBlock();

        $response = $this->post("api/pages/{$this->page->id}/blocks", $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'page_id',
                'data' => [
                    'heading',
                    'heading_alignment',
                    'heading_type'
                ]
            ]);

        $this->page->refresh();

        $this->assertEquals(1, $this->page->blocks()->count());
    }

    /** @test */
    public function user_can_update_a_block()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $block = factory(TextBlock::class)->make();
        $this->page->addBlock($block);

        $payload = ['data' => ['heading' => 'new heading'] + $block->data()];

        $this->put("api/pages/{$this->page->id}/blocks/{$block->id}", $payload)
            ->assertStatus(204);

        $block->refresh();

        $this->assertEquals('new heading', $block->data('heading'));
    }

    /** @test */
    public function user_can_update_block_order()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create(), 'api');

        factory(TextBlock::class, 2)->create(['page_id' => $this->page->id]);

        $payload = [
            [
                'id' => 1,
                'container' => 'new_1',
                'position' => 5,
            ], [
                'id' => 2,
                'container' => 'new_2',
                'position' => 10,
            ]
        ];

        $response = $this->put("api/pages/{$this->page->id}/blocks", $payload);

        $response->assertStatus(204);

        $this->assertDatabaseHas('blocks', $payload[0]);
        $this->assertDatabaseHas('blocks', $payload[1]);
    }
}
