<?php

namespace App\Http\Requests\PermissionGroup;

use App\Models\PermissionGroup;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class DeletePermissionGroupRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required_without:selected_id', Rule::exists('permission_groups', 'id')],
            'selected_id' => ['required_without:id', 'array', Rule::in(PermissionGroup::onlyTrashed()->get()->pluck('id')->toArray())],
            'force' => ['nullable', 'in:true,false']
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
