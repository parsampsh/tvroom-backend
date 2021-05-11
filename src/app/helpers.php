<?php

/**
 * Returns the permission error response
 *
 * @return \Illuminate\Http\JsonResponse
 */
function permission_error_response()
{
    return response()->json([
        'error' => "You don't have permission to call this API",
    ], 403);
}

/**
 * Returns the path of public html dir for uploaded images
 * @param string $subpath
 * @return string
 */
function img_upload_dir(string $subpath = '') : string
{
    return public_path('/uploads/img' . $subpath);
}
