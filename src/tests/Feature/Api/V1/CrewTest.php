<?php

namespace Tests\Feature\Api\V1;

use App\Models\Crew;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * Test crew can be created
     */
    public function test_crew_can_be_created()
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.v1.crews.create'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->actingAs($user)->post(route('api.v1.crews.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user->permissions()->create([
            'name' => 'create-crew',
        ]);

        $response = $this->actingAs($user)->post(route('api.v1.crews.create'));
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->actingAs($user)->post(route('api.v1.crews.create'), [
            'title' => 'Test crew',
            'en_title' => 'Test crew en',
            'description' => 'The test description for the crew',
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $created_crew = Crew::where('title', 'Test crew')
            ->where('en_title', 'Test crew en')
            ->where('description', 'The test description for the crew')
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotEmpty($created_crew);
        $this->assertEquals('crew-'.$created_crew->id, $created_crew->img);
        $this->assertEquals($created_crew->id, $response->json('crew')['id']);
        $this->assertFileExists(img_upload_dir('/'.$created_crew->img));
    }
}
