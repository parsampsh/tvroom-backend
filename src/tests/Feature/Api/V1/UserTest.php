<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * List of the users is accessible
     *
     * @return void
     */
    public function test_users_list_is_accessible()
    {
        $response = $this->get(route('api.v1.users.list'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('api.v1.users.list'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user->permissions()->create([
            'name' => 'get-users-list',
        ]);

        $response = $this->actingAs($user)->get(route('api.v1.users.list'));
        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals($response->json()['data'][0]['username'], $user->username);
    }
}
