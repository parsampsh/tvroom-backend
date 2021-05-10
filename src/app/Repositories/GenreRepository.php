<?php

namespace App\Repositories;

use App\Models\Genre;

class GenreRepository
{
    /**
     * Returns list of genres
     *
     * @return Genre[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Genre::all();
    }
}
