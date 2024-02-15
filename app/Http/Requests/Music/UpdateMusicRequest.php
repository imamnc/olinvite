<?php

namespace App\Http\Requests\Music;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateMusicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('music', 'id')],
            'title' => ['required', 'min:3', Rule::unique('music', 'title')->ignore($this->id)],
            'artist' => ['required', 'min:3', 'max:80']
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
