<?php

namespace Tests\Feature;

use App\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagePreviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_preview_a_page()
    {
        $this->withoutExceptionHandling();

        $page = factory(Page::class)->create();

        $this->get("api/pages/{$page->id}/preview")
            ->assertStatus(200);
    }
}
