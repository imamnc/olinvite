<?php

namespace App\Http\Requests\InvitationType;

use App\Models\InvitationType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RestoreInvitationTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required_without:selected_id', Rule::exists('invitation_types', 'id')],
            'selected_id' => ['required_without:id', 'array', Rule::in(InvitationType::onlyTrashed()->get()->pluck('id')->toArray())],
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
