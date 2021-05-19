<?php

namespace Tests\Feature\Api\V1;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * Genre can be created
     */
    public function test_genre_can_be_created()
    {
        $user = User::factory()->create();

        $response = $this->post(route('api.v1.genres.create'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->actingAs($user)->post(route('api.v1.genres.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user->permissions()->create([
            'name' => 'create-genre',
        ]);

        $response = $this->actingAs($user)->post(route('api.v1.genres.create'));
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->actingAs($user)->post(route('api.v1.genres.create'), [
            'title' => 'test genre',
            'en_title' => 'test genre en',
            'description' => 'test description',
            'image' => UploadedFile::fake()->image('test.png'),
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $created_genre = Genre::where('title', 'test genre')
            ->where('en_title', 'test genre en')
            ->where('description', 'test description')
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotEmpty($created_genre);
        $this->assertEquals('genre-'.$created_genre->id, $created_genre->img);
        $this->assertEquals($created_genre->id, $response->json('genre')['id']);
        $this->assertFileExists(img_upload_dir('/'.$created_genre->img));
    }

    /**
     * Genre can be deleted
     */
    public function test_genre_can_be_deleted()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $genre = Genre::factory()->create([
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user1)->delete(route('api.v1.genres.delete', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($user2)->delete(route('api.v1.genres.delete', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user1->permissions()->create(['name' => 'delete-any-genre']);

        $response = $this->actingAs($user1)->delete(route('api.v1.genres.delete', [$genre->id]));
        $response->assertStatus(Response::HTTP_OK);

        $genre = Genre::find($genre->id);
        $this->assertEmpty($genre);

        $genre = Genre::factory()->create([
            'user_id' => $user2->id,
        ]);

        $user2->permissions()->create(['name' => 'delete-genre']);
        $user3->permissions()->create(['name' => 'delete-genre']);

        $response = $this->actingAs($user3)->delete(route('api.v1.genres.delete', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($user2)->delete(route('api.v1.genres.delete', [$genre->id]));
        $response->assertStatus(Response::HTTP_OK);

        $genre = Genre::find($genre->id);
        $this->assertEmpty($genre);
    }

    /**
     * Genre can be updated
     */
    public function test_genre_can_be_updated()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $genre = Genre::factory()->create([
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user1)->put(route('api.v1.genres.update', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($user2)->put(route('api.v1.genres.update', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user1->permissions()->create(['name' => 'update-any-genre']);

        $response = $this->actingAs($user1)->put(route('api.v1.genres.update', [$genre->id]));
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->actingAs($user1)->put(route('api.v1.genres.update', [$genre->id]), [
            'title' => 'updated title',
            'en_title' => 'updated en title',
            'description' => 'updated description',
            'image' => UploadedFile::fake(),
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $genre->refresh();
        $this->assertEquals('updated title', $genre->title);
        $this->assertEquals('updated en title', $genre->en_title);
        $this->assertEquals('updated description', $genre->description);

        $genre = Genre::factory()->create([
            'user_id' => $user2->id,
        ]);

        $user2->permissions()->create(['name' => 'update-genre']);
        $user3->permissions()->create(['name' => 'update-genre']);

        $response = $this->actingAs($user3)->put(route('api.v1.genres.update', [$genre->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->actingAs($user2)->put(route('api.v1.genres.update', [$genre->id]));
        $response->assertStatus(Response::HTTP_FOUND);
    }
}
