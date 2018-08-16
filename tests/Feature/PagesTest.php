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
    public function user_can_create_a_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $payload = [
            'title' => 'awesome title',
            'slug' => 'awesome-title',
            'settings' => ['asd']
        ];

        $response = $this->post('api/pages/', $payload);

        $response->assertStatus(201)
            ->assertJson($payload);

        $id = $response->json('id');

        $this->assertNotNull(Page::find($id));
    }
}
