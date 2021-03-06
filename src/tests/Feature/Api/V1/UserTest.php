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

    /**
     * User can be created
     */
    public function test_user_can_be_created()
    {
        $response = $this->post(route('api.v1.users.create'), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $admin = User::factory()->create(['username' => 'admin', 'email' => 'admin@example.com']);

        $response = $this->actingAs($admin)->post(route('api.v1.users.create'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $admin->permissions()->create([
            'name' => 'create-user',
        ]);

        $response = $this->actingAs($admin)->post(route('api.v1.users.create'), []);
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->actingAs($admin)->post(route('api.v1.users.create'), []);
        $response->assertStatus(Response::HTTP_FOUND);

        $user = User::factory()->create(['username' => 'gerdoo', 'email' => 'gerdoo@cats.cats']);

        // username should be unique
        $response = $this->actingAs($admin)->post(route('api.v1.users.create'), [
            'username' => 'gerdoo',
            'email' => 'test@example.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CONFLICT);

        // email should be unique
        $response = $this->post(route('api.v1.users.create'), [
            'username' => 'parsa',
            'email' => 'gerdoo@cats.cats',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CONFLICT);

        $response = $this->post(route('api.v1.users.create'), [
            'username' => 'parsa',
            'email' => 'parsampsh@gmail.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $created_user = User::where('username', 'parsa')
            ->where('email', 'parsampsh@gmail.com')
            ->first();

        $this->assertNotEmpty($created_user);

        $this->assertEquals($created_user->username, $response->json('user')['username']);
    }

    /**
     * Information of once user is accessible
     */
    public function test_once_user_data_is_accessible()
    {
        $response = $this->get(route('api.v1.users.once', ['1']));
        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $user = User::factory()->create();

        $response = $this->get(route('api.v1.users.once', [$user->id]));
        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals($user->username, $response->json('username'));

        $response = $this->get(route('api.v1.users.once', [$user->username]));
        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals($user->username, $response->json('username'));
        $this->assertEquals($user->permissions->pluck('name')->toArray(), $response->json('permissions'));
    }

    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('api.v1.users.delete', [$user2->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user->permissions()->create([
            'name' => 'delete-user',
        ]);

        $user2->is_manager = true;
        $user2->save();

        $response = $this->actingAs($user)->delete(route('api.v1.users.delete', [$user2->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user2->is_manager = false;
        $user2->save();

        $response = $this->actingAs($user)->delete(route('api.v1.users.delete', [$user2->id]));
        $response->assertStatus(Response::HTTP_OK);

        $tmp_user_obj = User::find($user2->id);
        $this->assertEmpty($tmp_user_obj);
    }

    public function test_user_permissions_can_be_updated()
    {
        $user = User::factory()->create(['is_manager' => false]);
        $user2 = User::factory()->create(['is_manager' => false]);

        $response = $this->actingAs($user)->put(route('api.v1.users.update_permissions', $user2->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user->is_manager = true;
        $user->save();

        $response = $this->actingAs($user)->put(route('api.v1.users.update_permissions', $user2->id));
        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $user2->permissions()->create([
            'name' => 'other',
        ]);

        $this->assertFalse($user2->hasPermission('first'));
        $this->assertFalse($user2->hasPermission('last'));
        $this->assertTrue($user2->hasPermission('other'));

        $response = $this->actingAs($user)->put(route('api.v1.users.update_permissions', $user2->id), [
            'permissions' => [
                'first',
                'last',
            ]
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertTrue($user2->hasPermission('first'));
        $this->assertTrue($user2->hasPermission('last'));
        $this->assertFalse($user2->hasPermission('other'));
    }
}
