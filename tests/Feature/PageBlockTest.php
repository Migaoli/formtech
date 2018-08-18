<?php

namespace Tests\Feature;

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
}
