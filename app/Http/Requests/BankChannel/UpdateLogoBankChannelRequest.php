<?php

namespace App\Http\Requests\BankChannel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateLogoBankChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('bank_channels', 'id')->whereNull('deleted_at')],
            'logo' => ['required', 'mimes:png,jpg,jpeg,svg', 'max:2048']
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
