<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Creates a new user
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Returns list of the users via pagination
     *
     * @param Request $request
     */
    public function list(Request $request)
    {
        //
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
