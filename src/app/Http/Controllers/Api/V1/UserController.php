<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
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
        // check user permission
        if (! auth()->user()->has_permission('create-user')) {
            // log
            Log::notice('User that haven\'t permission tried to create a user', [
                'user_id' => auth()->user()->id,
            ]);

            return permission_error_response();
        }

        // validate request data
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|max:255|email',
            'password' => 'required|max:255',
        ]);

        // check username is unique
        $current_user = resolve(UserRepository::class)
            ->find_user_by_username($request->get('username'));
        if ($current_user !== null) {
            // log
            Log::notice('Someone tried to create a user with a username that already exists', [
                'user_id' => $current_user->id,
                'username' => $request->get('username'),
                'creator_user_id' => auth()->id(),
            ]);

            // username is reserved
            return response()->json([
                'error' => 'Username is already registered',
            ], Response::HTTP_CONFLICT);
        }

        // check email is unique
        $current_user = resolve(UserRepository::class)
            ->find_user_by_email($request->get('email'));
        if ($current_user !== null) {
            // log
            Log::notice('Someone tried to create a user with a email that already exists', [
                'user_id' => $current_user->id,
                'email' => $request->get('email'),
                'creator_user_id' => auth()->id(),
            ]);

            // email is reserved
            return response()->json([
                'error' => 'Email is already registered',
            ], Response::HTTP_CONFLICT);
        }

        // create the new user
        $created_user = resolve(UserRepository::class)->create($request);

        if (! $created_user) {
            // exception error
            return response()->json([
                'error' => 'Failed to create the user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // TODO : set a better status code
        }

        // log
        Log::notice('A New user was created', [
            'user_id' => $created_user->id,
            'creator_user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $created_user,
        ], Response::HTTP_CREATED);
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

            return permission_error_response();
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
    public function update(Request $request, $user)
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
    public function once(Request $request, string $user)
    {
        $user_obj = User::find($user);
        if ($user_obj === null) {
            $user_obj = resolve(UserRepository::class)->find_user_by_username($user);
        }

        if ($user_obj === null) {
            // log
            Log::info('Someone tried to get info of a user that not exists', [
                'requested_id' => $user,
            ]);

            return response()->json([
                'error' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // log
        Log::info('Showing info of a user', [
            'user_id' => $user_obj->id,
        ]);

        return $user_obj;
    }
}
