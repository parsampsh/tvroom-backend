<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreCollection;
use App\Repositories\GenreRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
