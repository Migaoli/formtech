<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_list_of_all_registered_blocks()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('api/blocks');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'type' => 'App\\Pages\\Blocks\\Text\\TextBlock'
            ]);
    }

    /** @test */
    public function can_get_meta_data_of_a_block()
    {
        $this->get('api/blocks/text_block')
            ->assertStatus(200)
            ->assertJson([
                'name' => 'text_block',
                'type' => 'App\\Pages\\Blocks\\Text\\TextBlock',
                'template' => 'test',
            ])
            ->assertJsonStructure(['fields']);

    }

    /** @test */
    public function get_404_if_block_does_not_exist()
    {
        $this->get('api/blocks/unknown_block_name')
            ->assertStatus(404);
    }
}
