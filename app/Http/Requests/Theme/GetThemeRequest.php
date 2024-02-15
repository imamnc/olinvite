<?php

namespace App\Http\Requests\Theme;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class GetThemeRequest extends FormRequest
{
    public function rules()
    {
        return [
            "id" => "nullable|exists:themes,id",
            "search" => "nullable",
            "sort_by" => "nullable|in:name,created_at",
            "sort_direction" => "nullable|alpha|in:asc,desc|required_with:sort_by",
            "page" => "nullable|numeric",
            "only_trashed" => "nullable|in:true,false",
            "fetch_type" => "nullable|in:data,count,id_collection"
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
