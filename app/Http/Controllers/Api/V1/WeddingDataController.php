<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeddingData\CoupleDataRequest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeddingDataController extends Controller
{
    /**
     * @OA\ Put(
     *     path="/wedding_data/couples",
     *     summary="Fill data wedding couples",
     *     tags={"Couples"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={"title","content","from"},
     *                 @OA\Property(
     *                     property="invitation_id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="groom_name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="groom_birthday",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="groom_birthplace",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="groom_father",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="groom_mother",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="bride_name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="bride_birthday",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="bride_birthplace",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="bride_father",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="bride_mother",
     *                     type="string",
     *                 ),
     *             ),
     *             example={
     *                 "invitation_id": 1,
     *                 "groom_name": "Romeo",
     *                 "groom_birthday": "1999-05-20",
     *                 "groom_birthplace": "Surabaya",
     *                 "groom_father": "Hercules",
     *                 "groom_mother": "Gamora",
     *                 "bride_name": "Juliet",
     *                 "bride_birthday": "2000-05-20",
     *                 "bride_birthplace": "Jakarta",
     *                 "bride_father": "Julio",
     *                 "bride_mother": "Shakira",
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="boolean"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *             example={
     *                  "success": true,
     *                  "message": "false",
     *                  "data": {}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="boolean"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="error_code",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *             example={
     *                  "success": false,
     *                  "message": "Validation errors",
     *                  "error_code": 422,
     *                  "data": {
     *                      "errors": {
     *                          "email": "<Error Messages>"
     *                      }
     *                  }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated Request",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="boolean"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="error_code",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *             example={
     *                 "success": false,
     *                 "message": "Unauthenticated",
     *                 "error_code": 401,
     *                 "data": {}
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="boolean"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="error_code",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *             example={
     *                  "success": false,
     *                  "message": "<Error Messages>",
     *                  "error_code": 500,
     *                  "data": {}
     *             }
     *         )
     *     ),
     * )
     */
    // Create data quote data
    public function couples(CoupleDataRequest $request)
    {
        try {
            // Add Material
            DB::beginTransaction();
            $invitation = Invitation::find($request->invitation_id);
            $payload = $request->except('invitation_id');
            $invitation->wedding_data()->update($payload);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }

        // Success response
        return $this->successResponse(trans('api-response.quote.create.success'), [
            "invitation" => $invitation
        ]);
    }
}
