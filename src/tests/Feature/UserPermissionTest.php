<?php

namespace Tests\Feature;

use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserPermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Method User::has_permission works correctly
     *
     * @return void
     */
    public function test_user_has_permission_works()
    {
        $user = User::factory()->create([
            'is_manager' => true,
        ]);

        $this->assertTrue($user->has_permission('permission-one'));
        $per1 = $user->permissions()->create([
            'name' => 'permission-two',
        ]);
        $this->assertTrue($user->has_permission('permission-two'));

        $user_2 = User::factory()->create([
            'is_manager' => false,
        ]);

        $this->assertFalse($user_2->has_permission('permission-one'));
        $user_2->permissions()->create([
            'name' => 'permission-two',
        ]);
        $this->assertTrue($user_2->has_permission('permission-two'));
    }
}
