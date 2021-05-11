<?php

namespace App\Repositories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function create(Request $request, User $user)
    {
        return $user->genres()->create([
            'title' => $request->get('title'),
            'en_title' => $request->get('en_title'),
            'description' => $request->get('description'),
            'img' => 'default.png',
        ]);
    }
}
