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

    /**
     * Creates a new genre from request data
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(Request $request, User $user)
    {
        return $user->genres()->create([
            'title' => $request->get('title'),
            'en_title' => $request->get('en_title'),
            'description' => $request->get('description'),
            'img' => 'default.png',
        ]);
    }

    /**
     * Deletes a genre
     *
     * @param Genre $genre
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Genre $genre)
    {
        return $genre->delete();
    }
}
