<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SendRsvpRequest extends FormRequest
{
    public function rules()
    {
        return [
            "invitation_id" => "required|numeric|exists:invitations,id",
            "guest_id" => "required|numeric|exists:guests,id",
            "person" => "nullable|required_if:confirmation,hadir|numeric|min:1|max:4",
            "confirmation" => "required|in:hadir,ragu,tidak",
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
