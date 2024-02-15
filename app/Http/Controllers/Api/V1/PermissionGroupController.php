<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionGroup\CreatePermissionGroupRequest;
use App\Http\Requests\PermissionGroup\DeletePermissionGroupRequest;
use App\Http\Requests\PermissionGroup\GetPermissionGroupRequest;
use App\Http\Requests\PermissionGroup\RestorePermissionGroupRequest;
use App\Http\Requests\PermissionGroup\UpdatePermissionGroupRequest;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionGroupController extends Controller
{
    /**
     * @OA\ Get(
     *     path="/permission_group",
     *     summary="Get permission groups data",
     *     tags={"Permission Groups"},
     *		@OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="To get sepesific data by ID",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="To get paginated data per page",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search data by permission group name",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="To sort data list by spesific column (name, created_at)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_direction",
     *         in="query",
     *         description="To set sort data direction (asc, desc)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="activation",
     *         in="query",
     *         description="To get data by activation status (all, active, nonactive)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="only_trashed",
     *         in="query",
     *         description="To get only trashed permission groups data",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="fetch_type",
     *         in="query",
     *         description="To specify fetch data type (data, count, id_collection)",
     *         required=false,
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
    // Get permission group data
    public function get(GetPermissionGroupRequest $request)
    {
        try {
            $data = [];
            // Main query
            $query = PermissionGroup::with('permissions');
            // Show only trashed if param only_trashed exists and true
            if (filter_var($request->only_trashed, FILTER_VALIDATE_BOOLEAN)) {
                $query = $query->onlyTrashed();
            }
            // Filter by activation
            if (!in_array($request->activation, [null, 'all'])) {
                $query = $query->where('is_active', ($request->activation == 'active') ? true : false);
            }
            // Continue filtering query
            if ($request->id) {
                $data['permission_group'] = $query->where('id', $request->id)->first();
            } else {
                if ($request->search) {
                    $query = $query->where('name', 'LIKE', "%$request->search%");
                }
                if ($request->sort_by) {
                    $query = $query->orderBy($request->sort_by, $request->sort_direction);
                }
                if ($request->page) {
                    $data['permission_groups'] = $query->paginate(10);
                } else {
                    switch ($request->fetch_type) {
                        case 'count':
                            $data['permission_groups'] = $query->count('id');
                            break;
                        case 'id_collection':
                            $data['permission_groups'] = $query->get()->pluck('id');
                            break;
                        default:
                            $data['permission_groups'] = $query->get();
                            break;
                    }
                }
            }
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), $th->getCode());
        }

        // Success response
        return $this->successResponse(trans('api-response.permission_group.get.success'), $data);
    }

    /**
     * @OA\ Post(
     *     path="/permission_group",
     *     summary="Create new permission group",
     *     tags={"Permission Groups"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={"name"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 )
     *             ),
     *             example={
     *                 "name": "Wedding Invitation"
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
    // Create data permission group data
    public function create(CreatePermissionGroupRequest $request)
    {
        try {
            // Add Material
            DB::beginTransaction();
            $payload = $request->only('name');
            $permission_group = PermissionGroup::create($payload);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }

        // Success response
        return $this->successResponse(trans('api-response.permission_group.create.success'), [
            "permission_group" => $permission_group
        ]);
    }

    /**
     * @OA\Put(
     *     path="/permission_group",
     *     summary="Update permission group data",
     *     tags={"Permission Groups"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={"id","name"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 example={
     *                     "id": 1,
     *				       "name": "Wedding Invitation",
     *			       }
     *             ),
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
    // Update data permission group data
    public function update(UpdatePermissionGroupRequest $request)
    {
        try {
            // Get permission group data
            $permission_group = PermissionGroup::find($request->id);

            DB::beginTransaction();
            $payload = $request->only('name');
            // Update data
            $permission_group->update($payload);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission_group.update.success'), [
            "permission_group" => $permission_group
        ]);
    }

    /**
     * @OA\ Delete(
     *     path="/permission_group",
     *     summary="Delete permission group data",
     *     tags={"Permission Groups"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *				@OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="selected_id[]",
     *                     type="array",
     *                     collectionFormat="multi",
     *                     @OA\Items(type="string", format="id"),
     *                 ),
     *                 @OA\Property(
     *                     property="force",
     *                     type="boolean"
     *                 )
     *             ),
     *				example={
     *					"id": 1,
     *					"force": false,
     *				}
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
     *                  "message": "Category deleted successfully",
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
    // Delete permission group data
    public function delete(DeletePermissionGroupRequest $request)
    {
        try {
            DB::beginTransaction();
            if (filter_var($request->force, FILTER_VALIDATE_BOOLEAN)) {
                if ($request->id) {
                    // Delete permanently per item
                    PermissionGroup::withTrashed()->find($request->id)->forceDelete();
                } else {
                    // Delete permanently bulk
                    PermissionGroup::withTrashed()->whereIn('id', $request->selected_id)->forceDelete();
                }
            } else {
                if ($request->id) {
                    // Soft delete per item
                    PermissionGroup::destroy($request->id);
                } else {
                    // Soft delete bulk
                    PermissionGroup::whereIn('id', $request->selected_id)->delete();
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission_group.delete.success'), [
            "status" => true
        ]);
    }

    /**
     * @OA\ Post(
     *     path="/permission_group/restore",
     *     summary="Restore deleted permission group data",
     *     tags={"Permission Groups"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *				@OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="selected_id[]",
     *                     type="array",
     *                     collectionFormat="multi",
     *                     @OA\Items(type="string", format="id"),
     *                 )
     *             ),
     *				example={
     *					"id": 1
     *				}
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
     *                  "message": "Category deleted successfully",
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
    // Restore deleted permission group data
    public function restore(RestorePermissionGroupRequest $request)
    {
        try {
            if ($request->id) {
                // Restore permanently per item
                PermissionGroup::withTrashed()->find($request->id)->restore();
            } else if ($request->selected_id) {
                // Restore permanently bulk
                PermissionGroup::withTrashed()->whereIn('id', $request->selected_id)->restore();
            } else {
                // Restore all
                PermissionGroup::onlyTrashed()->restore();
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission_group.restore.success'), [
            "status" => true
        ]);
    }
}
