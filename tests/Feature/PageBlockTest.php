<?php

namespace Tests\Feature;

use App\Blocks\Text\TextBlock;
use App\Pages\StandardPage;
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

        $this->page = factory(StandardPage::class)->create();
    }

    /** @test */
    public function user_can_update_block_order()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        factory(TextBlock::class, 2)->create(['page_id' => $this->page->id]);

        $payload = [
            [
                'id' => 1,
                'container' => 'new_1',
                'order' => 5,
            ], [
                'id' => 2,
                'container' => 'new_2',
                'order' => 10,
            ]
        ];

        $response = $this->json('put', "api/pages/{$this->page->id}/blocks", $payload);

        $response->assertStatus(204);

        $this->assertDatabaseHas('blocks', $payload[0]);
        $this->assertDatabaseHas('blocks', $payload[1]);
    }
}
