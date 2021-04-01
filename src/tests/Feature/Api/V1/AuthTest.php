<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can register by api
     */
    public function test_user_can_be_registered()
    {
        $response = $this->post(route('api.v1.auth.register'), []);
        $response->assertStatus(Response::HTTP_FOUND);

        $user = User::factory()->create(['username' => 'gerdoo', 'email' => 'gerdoo@cats.cats']);

        // username should be unique
        $response = $this->post(route('api.v1.auth.register'), [
            'username' => 'gerdoo',
            'email' => 'test@example.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CONFLICT);

        $response = $this->post(route('api.v1.auth.register'), [
            'username' => 'gerdoo',
            'email' => 'test@example.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CONFLICT);

        $response = $this->post(route('api.v1.auth.register'), [
            'username' => 'parsa',
            'email' => 'gerdoo@cats.cats',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CONFLICT);

        $response = $this->post(route('api.v1.auth.register'), [
            'username' => 'parsa',
            'email' => 'parsampsh@gmail.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $created_user = User::where('username', 'parsa')
            ->where('email', 'parsampsh@gmail.com')
            ->first();

        $this->assertNotEmpty($created_user);

        // check user is logged in after registration
        $this->assertAuthenticated();
    }

    /**
     * Checks user can login
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'parsampsh@gmail.com',
            'password' => Hash::make('123'),
        ]);

        $response = $this->post(route('api.v1.auth.login'), []);
        $response->assertStatus(Response::HTTP_FOUND);

        $response = $this->post(route('api.v1.auth.login'), [
            'email' => 'foo@bar',
            'password' => 'hello',
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->post(route('api.v1.auth.login'), [
            'email' => 'parsampsh@gmail.com',
            'password' => 'hello',
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->post(route('api.v1.auth.login'), [
            'email' => 'parsampsh@gmail.com',
            'password' => '123',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertAuthenticatedAs($user);
    }
}
