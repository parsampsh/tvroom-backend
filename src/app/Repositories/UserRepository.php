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

    /**
     * Creates a user from request data
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        return User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('username')),
        ]);
    }

    /**
     * Returns the paginated list of users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedList()
    {
        return User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.extra.users.list_per_page'));
    }

    /**
     * Deletes a user
     *
     * @param User $user
     * @return bool|null
     * @throws \Exception
     */
    public function delete(User $user)
    {
        return $user->delete();
    }

    /**
     * Finds a user by Id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return User::find($id);
    }
}
