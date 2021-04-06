<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
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
            // log
            Log::notice('User that haven\'t permission tried to get list of users', [
                'user_id' => auth()->user()->id,
            ]);

            abort(403);
        }

        $users = User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.extra.users.list_per_page'));

        // TODO : add additional options (filters) for the users

        // log
        Log::info('User received list of the users', [
            'user_id' => auth()->user()->id,
        ]);

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
