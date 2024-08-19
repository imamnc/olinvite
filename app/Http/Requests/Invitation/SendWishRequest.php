<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SendWishRequest extends FormRequest
{
    public function rules()
    {
        return [
            "invitation_id" => "required|numeric|exists:invitations,id",
            "guest_id" => "required|numeric|exists:guests,id",
            "name" => "required",
            "wish_text" => "required",
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
