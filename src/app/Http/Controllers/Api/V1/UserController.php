<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        if (! auth()->user()->hasPermission('create-user')) {
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
            ->findByUsername($request->get('username'));
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
            ->findByEmail($request->get('email'));
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
            'user' => new UserResource($created_user),
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
        if (! auth()->user()->hasPermission('get-users-list')) {
            // log
            Log::notice('User that haven\'t permission tried to get list of users', [
                'user_id' => auth()->user()->id,
            ]);

            return permission_error_response();
        }

        $users = resolve(UserRepository::class)->getPaginatedList();

        // TODO : add additional options (filters) for the users

        // log
        Log::info('User received list of the users', [
            'user_id' => auth()->user()->id,
        ]);

        $users->data = (new UserCollection($users))->toArray($request);

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
        // TODO : complete this action
    }

    /**
     * Deletes a user
     *
     * @param Request $request
     * @param User    $user
     */
    public function delete(Request $request, User $user)
    {
        if (! auth()->user()->hasPermission('delete-user')) {
            // log
            Log::notice('User that haven\'t permission tried to delete a user', [
                'user_id' => auth()->user()->id,
                'delete_user_id' => $user->id,
            ]);

            return permission_error_response();
        }

        // check if user is manager, die
        if ($user->is_manager) {
            return response()->json([
                'error' => 'You cannot delete this user',
            ], Response::HTTP_FORBIDDEN);
        }

        // delete the user
        // TODO : delete user non-relational dependencies
        resolve(UserRepository::class)->delete($user);

        // log
        Log::warning('User has been deleted', [
            'user_id' => $user->id,
            'deleter_user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'User has been deleted',
        ], response::HTTP_OK);
    }

    /**
     * Returns information of once user
     *
     * @param Request $request
     * @param User    $user
     */
    public function once(Request $request, string $user)
    {
        $user_obj = resolve(UserRepository::class)->findById($user);
        if ($user_obj === null) {
            $user_obj = resolve(UserRepository::class)->findByUsername($user);
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

        return new UserResource($user_obj);
    }

    /**
     * Updates list of user's permissions
     * @param Request $request
     */
    public function updatePermissions(Request $request, User $user)
    {
        // only the manager can change the permissions for other users
        if (! auth()->user()->is_manager) {
            return permission_error_response();
        }

        $new_permissions = $request->post('permissions');

        if (is_array($new_permissions)) {
            DB::transaction(function () use ($user, $new_permissions) {
                $user->permissions()->delete();

                foreach ($new_permissions as $permission) {
                    $user->permissions()->create([
                        'name' => $permission,
                    ]);
                }
            });
        } else {
            return response()->json([
                'error' => 'The permissions should be an array',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Permissions has been updated successfully',
        ]);
    }
}
