<?php

namespace App\Http\Requests\Guest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class GetGuestRequest extends FormRequest
{
    public function rules()
    {
        return [
            "id" => "nullable|exists:guests,id",
            "invitation_id" => "nullable|exists:invitations,id|required_with:link_name",
            "link_name" => "nullable",
            "search" => "nullable",
            "sort_by" => "nullable|in:name,created_at",
            "sort_direction" => "nullable|alpha|in:asc,desc|required_with:sort_by",
            "page" => "nullable|numeric",
            "activation" => "nullable|in:all,active,nonactive",
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
