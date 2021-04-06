<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Creates a new user
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO : write me
    }

    /**
     * Returns list of the users via pagination
     *
     * @param Request $request
     */
    public function list(Request $request)
    {
        // check user permission for getting list of users
        if (! auth()->user()->has_permission('get-users-list')) {
            abort(403);
        }

        $users = User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.extra.users.list_per_page'));

        // TODO : add additional options (filters) for the users

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Updates a user
     *
     * @param Request $request
     * @param User    $user
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Deletes a user
     *
     * @param Request $request
     * @param User    $user
     */
    public function delete(Request $request, User $user)
    {
        //
    }

    /**
     * Returns information of once user
     *
     * @param Request $request
     * @param User    $user
     */
    public function once(Request $request, User $user)
    {
        //
    }
}
