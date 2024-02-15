<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\ActivationPermissionRequest;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\DeletePermissionRequest;
use App\Http\Requests\Permission\GetPermissionRequest;
use App\Http\Requests\Permission\RestorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * @OA\ Get(
     *     path="/permission",
     *     summary="Get permissions data",
     *     tags={"Permissions"},
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
     *         description="Search data by permission name",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="To sort data list by spesific column (permission_group_name, name, created_at)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_direction",
     *         in="query",
     *         description="To set sort data direction (asc, desc)",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="only_trashed",
     *         in="query",
     *         description="To get only trashed permissions data",
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
    // Get permission data
    public function get(GetPermissionRequest $request)
    {
        try {
            $data = [];
            // Main query
            $query = Permission::with('group');
            // Show only trashed if param only_trashed exists and true
            if (filter_var($request->only_trashed, FILTER_VALIDATE_BOOLEAN)) {
                $query = $query->onlyTrashed();
            }
            // Filter by permission groups
            if ($request->permission_group_id) {
                if (count($request->permission_group_id) > 0) {
                    $query = $query->whereIn('permission_group_id', $request->permission_group_id);
                }
            }
            // Continue filtering query
            if ($request->id) {
                $data['permission'] = $query->where('id', $request->id)->first();
            } else {
                if ($request->search) {
                    $query = $query->where('permissions.name', 'LIKE', "%$request->search%");
                }
                if ($request->sort_by) {
                    if ($request->sort_by == 'permission_group_name') {
                        $query = $query->select('permissions.*')
                            ->join('permission_groups', 'permission_groups.id', '=', 'permissions.permission_group_id')
                            ->orderBy('permission_groups.name', $request->sort_direction);
                    } else {
                        $query = $query->orderBy("permissions.$request->sort_by", $request->sort_direction);
                    }
                }
                if ($request->page) {
                    $data['permissions'] = $query->paginate(10);
                } else {
                    switch ($request->fetch_type) {
                        case 'count':
                            $data['permissions'] = $query->count('id');
                            break;
                        case 'id_collection':
                            $data['permissions'] = $query->get()->pluck('id');
                            break;
                        default:
                            $data['permissions'] = $query->get();
                            break;
                    }
                }
            }
        } catch (\Throwable $th) {
            return $this->failedResponse($th->getMessage(), $th->getCode());
        }

        // Success response
        return $this->successResponse(trans('api-response.permission.get.success'), $data);
    }

    /**
     * @OA\ Post(
     *     path="/permission",
     *     summary="Create new permission",
     *     tags={"Permissions"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={"permission_group_id","name"},
     *                 @OA\Property(
     *                     property="permission_group_id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 )
     *             ),
     *             example={
     *                 "permission_group_id": 1,
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
    // Create data permission data
    public function create(CreatePermissionRequest $request)
    {
        try {
            // Add Material
            DB::beginTransaction();
            $payload = $request->only('permission_group_id', 'name');
            $payload['name'] = strtolower($$request->name);
            $permission = Permission::create($payload);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }

        // Success response
        return $this->successResponse(trans('api-response.permission.create.success'), [
            "permission" => $permission
        ]);
    }

    /**
     * @OA\Put(
     *     path="/permission",
     *     summary="Update permission data",
     *     tags={"Permissions"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *				@OA\Schema(
     *                 required={"id","permission_group_id","name"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="permission_group_id",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 ),
     *                 example={
     *                     "id": 1,
     *                     "permission_group_id": 2,
     *				       "name": "Invitations",
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
    // Update data permission data
    public function update(UpdatePermissionRequest $request)
    {
        try {
            // Get permission data
            $permission = Permission::find($request->id);

            DB::beginTransaction();
            $payload = $request->only('permission_group_id', 'name');
            // Update data
            $permission->update($payload);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission.update.success'), [
            "permission" => $permission
        ]);
    }

    /**
     * @OA\ Delete(
     *     path="/permission",
     *     summary="Delete permission data",
     *     tags={"Permissions"},
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
    // Delete permission data
    public function delete(DeletePermissionRequest $request)
    {
        try {
            DB::beginTransaction();
            if (filter_var($request->force, FILTER_VALIDATE_BOOLEAN)) {
                if ($request->id) {
                    // Delete permanently per item
                    Permission::withTrashed()->find($request->id)->forceDelete();
                } else {
                    // Delete permanently bulk
                    Permission::withTrashed()->whereIn('id', $request->selected_id)->forceDelete();
                }
            } else {
                if ($request->id) {
                    // Soft delete per item
                    Permission::destroy($request->id);
                } else {
                    // Soft delete bulk
                    Permission::whereIn('id', $request->selected_id)->delete();
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission.delete.success'), [
            "status" => true
        ]);
    }

    /**
     * @OA\ Post(
     *     path="/permission/restore",
     *     summary="Restore deleted permission data",
     *     tags={"Permissions"},
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
    // Restore deleted permission data
    public function restore(RestorePermissionRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->id) {
                // Restore permanently per item
                Permission::withTrashed()->find($request->id)->restore();
            } else if ($request->selected_id) {
                // Restore permanently bulk
                Permission::withTrashed()->whereIn('id', $request->selected_id)->restore();
            } else {
                // Restore all
                Permission::onlyTrashed()->restore();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->failedResponse($e->getMessage(), $e->getCode());
        }
        // Success response
        return $this->successResponse(trans('api-response.permission.restore.success'), [
            "status" => true
        ]);
    }
}
