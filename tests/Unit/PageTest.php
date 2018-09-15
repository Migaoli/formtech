<?php

namespace Tests\Unit;

use App\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function auto_generate_slug_if_none_is_provided()
    {
        $page = new Page(['title' => 'awesome page']);

        $this->assertEquals('awesome-page', $page->slug());
    }

    /** @test */
    public function do_not_auto_generate_slug_if_one_is_provided()
    {
        $page = new Page(['title' => 'awesome page', 'slug' => 'test']);
        $this->assertEquals('test', $page->slug());
    }

    /** @test */
    public function pages_with_same_parent_must_have_unique_slugs()
    {
        factory(Page::class)->create(['slug' => 'duplicate']);

        $duplicate = factory(Page::class)->make(['slug' => 'duplicate']);

        $this->assertThrows(ValidationException::class, function () use ($duplicate) {
            $duplicate->save();
        });
    }

    /** @test */
    public function pages_with_different_parents_can_have_the_same_slug()
    {
        $parent = factory(Page::class)->create(['slug' => 'duplicate']);
        $allowedDuplicate = factory(Page::class)->make(['slug' => 'duplicate', 'parent_id' => $parent->id]);

        $this->assertTrue($allowedDuplicate->save());
    }

    /** @test */
    public function a_page_can_have_sub_pages()
    {
        $page = factory(Page::class)->create();
        $sub = factory(Page::class)->make();

        $page->addSubPage($sub);

        $this->assertEquals(1, $page->subPages()->count());
    }
}
