<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Olinvite API",
     *      description="This is an official documentation of Olinvite API. This documentation is used for knowing the rules in consuming the resource of this API.",
     *      @OA\Contact(
     *          email="contact@olinvite.id"
     *      ),
     *      @OA\License(
     *          name="Nginx",
     *          url="https://nginx.org/LICENSE"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Main Server"
     * )
     *
     * @OAS\SecurityScheme(
     *     securityScheme="sanctum",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT"
     * )
     *
     * @OA\Tag(
     *     name="Authentication",
     *     description="API Endpoints Group of Authentication"
     * )
     * @OA\Tag(
     *     name="Region",
     *     description="API Endpoints Group of Region"
     * )
     * @OA\Tag(
     *     name="Bank Channels",
     *     description="API Endpoints Group of Bank Channels"
     * )
     * @OA\Tag(
     *     name="Invitation Types",
     *     description="API Endpoints Group of Invitation Types"
     * )
     * @OA\Tag(
     *     name="Payment Channels",
     *     description="API Endpoints Group of Payment Channels"
     * )
     * @OA\Tag(
     *     name="Permission Groups",
     *     description="API Endpoints Group of Permission Groups"
     * )
     * @OA\Tag(
     *     name="Permissions",
     *     description="API Endpoints Group of Permissions"
     * )
     * @OA\Tag(
     *     name="Roles",
     *     description="API Endpoints Group of Roles"
     * )
     * @OA\Tag(
     *     name="Users",
     *     description="API Endpoints Group of Users"
     * )
     * @OA\Tag(
     *     name="Music",
     *     description="API Endpoints Group of Music"
     * )
     * @OA\Tag(
     *     name="Themes",
     *     description="API Endpoints Group of Themes"
     * )
     * @OA\Tag(
     *     name="Quotes",
     *     description="API Endpoints Group of Quotes"
     * )
     * @OA\Tag(
     *     name="Invitations",
     *     description="API Endpoints Group of Invitations"
     * )
     * @OA\Tag(
     *     name="Guests",
     *     description="API Endpoints Group of Invitation Guests"
     * )
     * @OA\Tag(
     *     name="Wedding Data",
     *     description="API Endpoints Group of Wedding Data"
     * )
     *
     * @OA\Schema(
     *     schema="SuccessResult",
     *     title="Schemas for success response",
     * 	   @OA\Property(
     * 		   property="success",
     * 		   type="boolean"
     * 	   ),
     * 	   @OA\Property(
     * 		   property="message",
     * 		   type="string"
     * 	   ),
     * 	   @OA\Property(
     * 		   property="data",
     * 		   type="object"
     * 	   ),
     * )
     * @OA\Schema(
     *     schema="FailedResult",
     *     title="Schemas for failed response",
     * 	   @OA\Property(
     * 		   property="success",
     * 		   type="boolean"
     * 	   ),
     * 	   @OA\Property(
     * 		   property="message",
     * 		   type="string"
     * 	   ),
     * 	   @OA\Property(
     * 		   property="error_code",
     * 		   type="integer"
     * 	   ),
     * 	   @OA\Property(
     * 		   property="data",
     * 		   type="object"
     * 	   ),
     * )
     *
     */

    // API Success response
    protected function successResponse(string $message, array $data = [])
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    // API Failed response
    protected function failedResponse(string $message, $code = Response::HTTP_INTERNAL_SERVER_ERROR, array $data = [])
    {
        $code = ($code != 0 && is_int($code)) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;
        return response()->json([
            'success' => false,
            'message' => $message,
            'error_code' => $code,
            'data' => (object) $data
        ], $code);
    }

    // Check user permissions
    protected function checkPermission($permission)
    {
        if (!in_array($permission, auth('sanctum')->user()->role->permissions->pluck('name')->toArray())) {
            throw new \Exception("Token doesn't have permission to use this API", Response::HTTP_FORBIDDEN);
        }
    }

    // Upload File
    protected function uploadFile($file, $path)
    {
        $file_path = $file->storePublicly($path);
        $file_path = $file_path ? "storage/$file_path" : null;
        return $file_path;
    }

    // Remove File
    protected function removeFile($path)
    {
        $file_path = str_replace(env('APP_URL'), '', $path);
        $file_path = str_replace('storage/', '', $file_path);
        if (Storage::exists($file_path)) {
            Storage::delete($file_path);
            return true;
        }
        return false;
    }

    // Generate random strings
    protected function random_strings($length_of_string)
    {
        return substr(bin2hex(random_bytes($length_of_string)), 0, $length_of_string);
    }
}
