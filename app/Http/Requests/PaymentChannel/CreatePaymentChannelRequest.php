<?php

namespace App\Http\Requests\PaymentChannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreatePaymentChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'bank_channel_id' => 'required|exists:bank_channels,id',
            'name' => 'required|min:3|regex:/^[a-zA-Z\s]*$/',
            'number' => 'required|min:5|numeric|unique:payment_channels,number',
            'is_active' => ['nullable', 'boolean']
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
