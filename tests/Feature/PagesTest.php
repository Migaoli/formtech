<?php

namespace Tests\Feature;

use App\Page;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_get_page_by_id()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $page = factory(Page::class)->create();

        $response = $this->get('api/pages/' . $page->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'settings' => $page->settings
            ]);
    }

    /** @test */
    public function user_can_get_list_of_all_pages()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        factory(Page::class, 10)->create();

        $response = $this->get('api/pages');

        $response->assertStatus(200)
            ->assertJsonCount(10)
            ->assertJsonFragment([
                '*' => [
                    'id', 'title', 'slug', 'settings', 'created_at', 'updated_at'
                ]
            ]);
    }

    /** @test */
    public function user_can_create_a_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $this->withoutExceptionHandling();

        $payload = [
            'title' => 'awesome title',
            'slug' => 'awesome-title',
            'layout' => 'landing_page',
            'settings' => ['asd']
        ];

        $response = $this->json('post', 'api/pages/', $payload);

        $response->assertStatus(201)
            ->assertJson($payload);

        $id = $response->json('id');

        $this->assertNotNull(Page::find($id));
    }
}
