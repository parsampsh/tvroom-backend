<?php

namespace Tests\Feature\Api\V1;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * List of genres is accessible
     */
    public function test_list_of_genres_is_accessible()
    {
        Genre::factory(5)->create();

        $response = $this->get(route('api.v1.genres.list'));
        $response->assertStatus(200);

        $this->assertEquals(5, count($response->json()));
        $this->assertEquals(Genre::first()->title, $response->json()[0]['title']);
        $this->assertEquals(Genre::first()->user->id, $response->json()[0]['user']['id']);
    }
}
