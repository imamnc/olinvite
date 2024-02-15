<?php

namespace App\Http\Requests\Theme;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateThemeThumbnailsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('themes', 'id')->whereNull('deleted_at')],
            'thumbnails' => ['required', 'mimes:png,jpg,jpeg,svg', 'max:2048']
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
