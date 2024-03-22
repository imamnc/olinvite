<?php

namespace App\Http\Requests\WeddingData;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class EventDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invitation_id' => 'required|exists:invitations,id',
            'akad_feature' => 'required|boolean',
            'akad_date' => 'nullable|required_if:akad_feature,true|date',
            'akad_start' => 'nullable|required_if:akad_feature,true|string',
            'akad_end' => 'nullable|required_if:akad_feature,true|string',
            'akad_place' => 'nullable|required_if:akad_feature,true|string',
            'akad_maps' => 'nullable|required_if:akad_feature,true|string',
            'reception_feature' => 'required|boolean',
            'reception_date' => 'nullable|required_if:reception_feature,true|date',
            'reception_start' => 'nullable|required_if:reception_feature,true|string',
            'reception_end' => 'nullable|required_if:reception_feature,true|string',
            'reception_place' => 'nullable|required_if:reception_feature,true|string',
            'reception_maps' => 'nullable|required_if:reception_feature,true|string'
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
