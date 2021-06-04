<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CrewCollection;
use App\Http\Resources\CrewResource;
use App\Repositories\CrewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Creates a new crew
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // check the user permission
        if (! auth()->user()->hasPermission('create-crew')) {
            // log
            Log::notice('A user that has not permission tried to create a new crew', [
                'user_id' => auth()->id(),
            ]);

            return permission_error_response();
        }

        // validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'en_title' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'image', // TODO : make limitation on the file size
        ]);

        // create the new crew
        $created_crew = resolve(CrewRepository::class)->create(auth()->user(), $request);

        // log
        Log::notice('A new crew was created', [
            'crew_id' => $created_crew->id,
        ]);

        // upload the image
        $img_file = $request->file('image');
        if ($img_file) {
            $img_name = 'crew-'.$created_crew->id;
            $img_file->move(img_upload_dir(), $img_name);
            $created_crew->img = $img_name;
            $created_crew->save();
        }

        return response()->json([
            'message' => 'The new Crew has been created successfully',
            'crew' => (new CrewResource($created_crew))->toArray($request),
        ], Response::HTTP_CREATED);
    }
}
