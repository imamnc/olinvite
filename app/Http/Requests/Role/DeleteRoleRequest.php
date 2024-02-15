<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class DeleteRoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required_without:selected_id', Rule::exists('roles', 'id')],
            'selected_id' => ['required_without:id', 'array', Rule::in(Role::onlyTrashed()->get()->pluck('id')->toArray())],
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
