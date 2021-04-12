<?php

/**
 * Returns the permission error response
 *
 * @return \Illuminate\Http\JsonResponse
 */
function permission_error_response() {
    return response()->json([
        'error' => "You don't have permission to call this API",
    ], 403);
}
