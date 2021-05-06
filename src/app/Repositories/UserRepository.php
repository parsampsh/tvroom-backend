<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Finds a user by username
     *
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): User|null
    {
        return User::where('username', $username)->first();
    }

    /**
     * Finds a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function create(Request $request)
    {
        return User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('username')),
        ]);
    }

    public function getPaginatedList()
    {
        return User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.extra.users.list_per_page'));
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function findById($id)
    {
        return User::find($id);
    }
}
