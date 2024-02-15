<?php

namespace App\Http\Requests\PaymentChannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdatePaymentChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('payment_channels', 'id')],
            'bank_channel_id' => ['required', 'numeric', 'exists:bank_channels,id'],
            'name' => ['required', 'min:3', 'regex:/^[a-zA-Z\s]*$/', Rule::unique('payment_channels')->ignore($this->id)],
            'number' => ['required', 'min:5', 'numeric', Rule::unique('payment_channels')->ignore($this->id)]
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
