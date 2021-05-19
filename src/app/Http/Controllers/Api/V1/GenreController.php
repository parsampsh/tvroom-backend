<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreCollection;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Repositories\GenreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    /**
     * Returns list of the genres
     *
     * @param Request $request
     */
    public function list(Request $request)
    {
        $genres = resolve(GenreRepository::class)->list();

        // log
        Log::info('Showing list of the genres');

        return new GenreCollection($genres);
    }

    /**
     * Creates a new genre
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // check the user's permission
        if (! auth()->user()->hasPermission('create-genre')) {
            // log
            Log::notice('User that haven\'t permission tried to create a genre', [
                'user_id' => auth()->user()->id,
            ]);

            return permission_error_response();
        }

        // validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'en_title' => 'required|max:255',
            'description' => 'required|max:255',
            'img' => 'image',
        ]);

        // create the new genre
        $created_genre = resolve(GenreRepository::class)->create($request, auth()->user());

        // log
        Log::notice('A new genre was created', [
            'genre_id' => $created_genre->id,
        ]);

        // upload the image
        $img_file = $request->file('image');
        if ($img_file) {
            // TODO : make limitation on the file size
            $img_name = 'genre-'.$created_genre->id;
            $img_file->move(img_upload_dir(), $img_name);
            $created_genre->img = $img_name;
            $created_genre->save();
        }

        return response()->json([
            'message' => 'The new genre has been created successfully',
            'genre' => (new GenreResource($created_genre))->toArray($request),
        ], Response::HTTP_CREATED);
    }

    public function delete(Request $request, Genre $genre)
    {
        // check has user permission for deleting the genre
        if (! auth()->user()->hasPermission('delete-any-genre')) {
            if (
                ! auth()->user()->hasPermission('delete-genre') ||
                $genre->user_id !== auth()->id()
            ) {
                // log
                Log::notice('Someone that has not permission tried to delete a genre', [
                    'user_id' => auth()->id(),
                    'genre_id' => $genre->id,
                ]);

                return permission_error_response();
            }
        }

        // delete the genre
        resolve(GenreRepository::class)->delete($genre);

        // log
        Log::notice('A Genre has been deleted', [
            'user_id' => auth()->id(),
            'genre_id' => $genre->id,
        ]);

        return response()->json([
            'message' => 'Genre has been deleted successfully',
        ]);
    }
}
