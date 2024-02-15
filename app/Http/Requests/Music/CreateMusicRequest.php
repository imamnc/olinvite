<?php

namespace App\Http\Requests\Music;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateMusicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|min:3|unique:music,title',
            'artist' => 'required|min:3|max:80',
            'music' => ['required', 'mimes:mp3', 'max:10240'],
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
