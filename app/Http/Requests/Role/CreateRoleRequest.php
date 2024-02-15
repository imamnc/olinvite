<?php

namespace App\Http\Requests\Role;

use App\Models\Permission;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:roles,name',
            'permissions' => ['required', 'array', Rule::in(Permission::get()->pluck('id')->toArray())]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'error_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'data' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
