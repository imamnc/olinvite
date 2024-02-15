<?php

namespace App\Http\Requests\Theme;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CreateThemeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invitation_type_id' => ['required', 'exists:invitation_types,id'],
            'name' => ['required', 'min:3', 'max:80', 'unique:themes,name'],
            'path' => ['required', 'min:3', 'max:50', 'unique:themes,path'],
            'thumbnails' => ['nullable', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'price' => ['required', 'numeric']
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
