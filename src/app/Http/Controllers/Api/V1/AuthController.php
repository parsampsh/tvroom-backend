<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
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
        $current_user = resolve(UserRepository::class)
            ->find_user_by_username($request->get('username'));
        if ($current_user !== null) {
            // log
            Log::notice('Someone tried to register a username that already exists', [
                'user_id' => $current_user->id, 'username' => $request->get('username')
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
            Log::notice('Someone tried to register a email that already exists', [
                'user_id' => $current_user->id, 'email' => $request->get('email')
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
                'error' => 'Failed to register the user',
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // TODO : set a better status code
        }

        // log
        Log::notice('A New user was registered', ['user_id' => $created_user->id]);

        // login the created user
        auth()->login($created_user);

        return response()->json([
            'message' => 'User registered successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Logins the user by credentials
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        // validate the request
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // check the remember flag
        $remember = (bool) $request->post('remember');

        // attempt credentials
        if (auth()->attempt($request->all(['email', 'password']), $remember)) {
            // log
            Log::info('User logged in', ['user_id' => auth()->user()->id]);

            // login successful
            return response()->json([
                'message' => 'Login successful',
            ], Response::HTTP_OK);
        }

        $exists_user = resolve(UserRepository::class)
            ->find_user_by_email($request->get('email'));
        if ($exists_user !== null) {
            if ($exists_user->is_manager) {
                // log
                Log::critical('Invalid password entered for MANAGER user', ['user_id' => $exists_user->id]);
            } else {
                // log
                Log::warning('Invalid password entered for user', ['user_id' => $exists_user->id]);
            }
        } else {
            // log
            Log::notice('Invalid login', ['email' => $request->post('email')]);
        }

        // invalid credentials
        return response()->json([
            'error' => 'Invalid credentials',
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns info of the current authenticated user
     *
     * @param Request $request
     */
    public function info(Request $request)
    {
        if (! auth()->check()) {
            // log
            Log::info('A non-authenticated user requested to get user info');

            // user is not logged in
            return response()->json([
                'error' => 'User is not authenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // log
        Log::info('Showing information of the logged in user', [
            'user_id' => auth()->user()->email,
        ]);

        return auth()->user();
    }

    /**
     * Logouts the user
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        if (! auth()->check()) {
            // log
            Log::info('A non-authenticated user requested to logout');

            // user is not logged in
            return response()->json([
                'error' => 'User is not authenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // log
        Log::info('User logged out', ['user_id' => auth()->user()->id]);

        auth()->logout();

        return response()->json([
            'message' => 'User logged out successfully',
        ], Response::HTTP_OK);
    }
}
