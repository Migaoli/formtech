<?php

namespace Tests\Feature;

use App\Pages\StandardPage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function can_can_get_meta_data()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $this->withoutExceptionHandling();

        $response = $this->json('get', 'api/pages/meta');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'type',
                    'fields',
                ],
            ]);
    }


    /** @test */
    public function can_get_page_by_id()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $page = factory(StandardPage::class)->create();

        $response = $this->json('get', 'api/pages/' . $page->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
            ]);
    }

    /** @test */
    public function user_can_get_list_of_all_pages()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        factory(StandardPage::class, 10)->create();

        $response = $this->json('get', 'api/pages');

        $response->assertStatus(200)
            ->assertJsonCount(10)
            ->assertJsonStructure([
                '*' => [
                    'id', 'title', 'slug', 'created_at', 'updated_at'
                ]
            ]);
    }

    /** @test */
    public function user_can_create_a_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $this->withoutExceptionHandling();

        $payload = [
            'type' => 'standard_page',
            'title' => 'awesome title',
            'slug' => 'awesome-title',
            'in_menu' => true,
            'published' => false,
        ];

        $response = $this->json('post', 'api/pages/', $payload);

        $response->assertStatus(201);

        $id = $response->json('id');

        $this->assertNotNull(StandardPage::find($id));
    }

    /** @test */
    public function user_can_update_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        //$this->withoutExceptionHandling();

        $page = factory(StandardPage::class)->create();

        $payload = [
            'title' => 'new title',
            'slug' => 'new-slug',
            'published' => true,
            'in_menu' => true,
            'data' => [
                'layout' => 'landing_page',
            ],
        ];

        $response = $this->json('put', "api/pages/$page->id", $payload);

        $response->assertStatus(204);

        $page->refresh();

        $this->assertEquals('new title', $page->title);
    }

    /** @test */
    public function user_can_delete_page()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $page = factory(StandardPage::class)->create();

        $this->json('delete', "api/pages/$page->id")
            ->assertStatus(204);

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    /** @test */
    public function delete_sub_pages()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $page = factory(StandardPage::class)->create();
        $subPage = factory(StandardPage::class)->create(['parent_id' => $page->id]);

        $this->json('delete', "api/pages/$page->id", ['deleteSubPages' => true])
            ->assertStatus(204);

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
        $this->assertDatabaseMissing('pages', ['id' => $subPage->id]);
    }

    /** @test */
    public function move_sub_pages_up_on_delete()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $page = factory(StandardPage::class)->create();
        $subPage = factory(StandardPage::class)->create(['parent_id' => $page->id]);

        $this->json('delete', "api/pages/$page->id", ['deleteSubPages' => false])
            ->assertStatus(204);

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
        $this->assertDatabaseHas('pages', ['id' => $subPage->id, 'parent_id' => null]);
    }
}
