<?php

namespace App\Http\Requests\Music;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateFileMusicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('music', 'id')->whereNull('deleted_at')],
            'music' => ['required', 'mimes:mp3', 'max:10240']
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
