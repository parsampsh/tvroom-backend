<?php

namespace Tests\Feature\Api\V1;

use App\Models\Crew;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The list of the crews is accessible
     *
     * @return void
     */
    public function test_list_of_crews_is_accessible()
    {
        Crew::factory(5)->create();

        $response = $this->get(route('api.v1.crews.list'));
        $response->assertStatus(200);

        $this->assertEquals(5, count($response->json('data')));
        $this->assertEquals(Crew::first()->title, $response->json('data')[0]['title']);
    }
}
