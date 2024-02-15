<?php

namespace App\Http\Requests\PermissionGroup;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdatePermissionGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('permission_groups', 'id')],
            'name' => [
                'required', 'min:3',
                Rule::unique('permission_groups')->ignore($this->id)
            ]
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
