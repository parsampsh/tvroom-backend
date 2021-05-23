<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CrewCollection;
use App\Repositories\CrewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CrewController extends Controller
{
    public function list(Request $request)
    {
        // load list of the crews
        $crews = resolve(CrewRepository::class)->getPaginatedList();

        // log
        Log::info('Showing list of the crews');

        $crews->data = (new CrewCollection($crews))->toArray($request);
        return $crews;
    }
}
