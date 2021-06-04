<?php


namespace App\Repositories;

use App\Models\Crew;
use App\Models\User;
use Illuminate\Http\Request;

class CrewRepository
{
    /**
     * Returns paginated list of the crews
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedList(int $perPage = 30)
    {
        return Crew::query()->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Creates a new crew
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(User $user, Request $request)
    {
        return $user->crews()->create([
            'title' => $request->get('title'),
            'en_title' => $request->get('en_title'),
            'description' => $request->get('description'),
            'img' => 'default.png',
        ]);
    }
}
