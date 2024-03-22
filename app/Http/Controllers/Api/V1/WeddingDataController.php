<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeddingData\CoupleDataRequest;
use App\Http\Requests\WeddingData\EventDataRequest;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeddingDataController extends Controller
{
    /**
     * @OA\ Put(
     *     path="/wedding_data/couples",
     *     summary="Fill data wedding couples",
     *     tags={"Wedding Data"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={
     *                     "invitation_id","groom_name","groom_birthday","groom_birthplace","groom_father","groom_mother",
     *                     "bride_name","bride_birthday","bride_birthplace","bride_father","bride_mother"
     *                 },
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

    /**
     * @OA\ Put(
     *     path="/wedding_data/events",
     *     summary="Fill data wedding events",
     *     tags={"Wedding Data"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={
     *                     "invitation_id","akad_date","akad_start","akad_end","akad_place","akad_maps",
     *                     "akad_date","akad_start","akad_end","akad_place","akad_maps"
     *                 },
     *                 @OA\Property(
     *                     property="invitation_id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="akad_feature",
     *                     type="boolean",
     *                 ),
     *                 @OA\Property(
     *                     property="akad_date",
     *                     type="date",
     *                 ),
     *                 @OA\Property(
     *                     property="akad_start",
     *                     type="time",
     *                 ),
     *                 @OA\Property(
     *                     property="akad_place",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="akad_maps",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_feature",
     *                     type="boolean",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_date",
     *                     type="date",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_start",
     *                     type="time",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_end",
     *                     type="time",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_place",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="reception_maps",
     *                     type="string",
     *                 )
     *             ),
     *             example={
     *                 "invitation_id": 1,
     *                 "akad_feature": true,
     *                 "akad_date": "2024-05-20",
     *                 "akad_start": "14:00",
     *                 "akad_end": "20:00",
     *                 "akad_place": "Masjid Agung Surabaya",
     *                 "akad_maps": "link from google maps embed",
     *                 "reception_feature": true,
     *                 "reception_date": "2024-05-21",
     *                 "reception_start": "14:00",
     *                 "reception_end": "20:00",
     *                 "reception_place": "Garden Palace Surabaya",
     *                 "reception_maps": "link from google maps embed"
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
    public function events(EventDataRequest $request)
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
