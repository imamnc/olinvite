<?php

namespace App\Http\Requests\BankChannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateBankChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('bank_channels', 'id')],
            'name' => [
                'required', 'min:3',
                Rule::unique('bank_channels')->ignore($this->id)
            ],
            'short_name' => [
                'required', 'max:7',
                Rule::unique('bank_channels')->ignore($this->id)
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
