<?php

namespace App\Http\Requests\BankChannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateBankChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:bank_channels,name',
            'short_name' => 'required|min:3|max:7|unique:bank_channels,short_name',
            'logo' => ['nullable', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
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
