<?php


namespace App\Repositories;

use App\Models\Crew;

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
}
