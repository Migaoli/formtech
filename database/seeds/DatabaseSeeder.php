<?php

use App\Pages\StandardPage;
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

        $page = factory(StandardPage::class)->create();
        factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1', 'order' => 3]);
        factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1', 'order' => 2]);
        factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1', 'order' => 1]);
    }

    private function createPageTree()
    {
        $roots = factory(StandardPage::class, 1)->create();

        foreach ($roots as $root) {
            $subs = $this->createChildren($root, random_int(0, 2));
        }
    }

    private function createChildren($parent, $amount)
    {
        return factory(StandardPage::class, $amount)->create(['parent_id' => $parent->id]);
    }

    private function addContent()
    {
        StandardPage::all()
            ->each(function ($page) {
                factory(\App\Blocks\Gallery\GalleryBlock::class)->create(['page_id' => $page->id, 'container' => 'c1']);
                factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c1']);
                factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c2']);
                factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c3']);
                factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c4']);
                factory(\App\Blocks\Text\TextBlock::class)->create(['page_id' => $page->id, 'container' => 'c5']);
            });
    }
}
