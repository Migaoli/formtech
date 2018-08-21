<?php

use App\Page;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->createPageTree();
        $this->addContent();

        $page = factory(Page::class)->create(['layout' => 'single_page']);
        factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1']);
    }

    private function createPageTree()
    {
        $roots = factory(Page::class, 1)->create();

        foreach ($roots as $root) {
            $subs = $this->createChildren($root, random_int(0, 2));
        }
    }

    private function createChildren($parent, $amount)
    {
        return factory(Page::class, $amount)->create(['parent_id' => $parent->id]);
    }

    private function addContent()
    {
        Page::all()
            ->each(function ($page) {
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1']);
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1']);
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c2']);
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c3']);
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c4']);
            });
    }
}
