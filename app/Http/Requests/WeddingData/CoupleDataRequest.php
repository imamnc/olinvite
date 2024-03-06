<?php

namespace App\Http\Requests\WeddingData;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CoupleDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invitation_id' => 'required|exists:invitations,id',
            'groom_name' => 'required',
            'groom_birthday' => 'required|date',
            'groom_birthplace' => 'required',
            'groom_father' => 'required',
            'groom_mother' => 'required',
            'bride_name' => 'required',
            'bride_birthday' => 'required|date',
            'bride_birthplace' => 'required',
            'bride_father' => 'required',
            'bride_mother' => 'required',
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
