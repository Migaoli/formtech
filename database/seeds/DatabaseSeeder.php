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
    }

    private function createPageTree()
    {
        $roots = factory(Page::class, 5)->create();

        foreach ($roots as $root) {
            $subs = $this->createChildren($root, random_int(0, 2));

            foreach ($subs as $sub) {
                $this->createChildren($sub, random_int(0, 2));
            }
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
                factory(\App\Blocks\TextBlock::class)->create(['page_id' => $page->id]);
            });
    }
}
