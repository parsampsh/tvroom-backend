<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Registers a user
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        // validate request data
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|max:255|email',
            'password' => 'required|max:255',
        ]);

        // check username is unique
        if (resolve(UserRepository::class)
            ->find_user_by_username($request->get('username')) !== null
        ) {
            // username is reserved
            return response()->json([
                'error' => 'Username is already registered',
            ], Response::HTTP_CONFLICT);
        }

        // check email is unique
        if (resolve(UserRepository::class)
                ->find_user_by_email($request->get('email')) !== null
        ) {
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
                'error' => 'Failed to register the user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // TODO : set a better status code
        }

        // login the created user
        auth()->login($created_user);

        return response()->json([
            'message' => 'User registered successfully',
        ], Response::HTTP_CREATED);
    }
}
