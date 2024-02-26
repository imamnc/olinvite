<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CreateInvitationRequest extends FormRequest
{
    public function rules()
    {
        return [
            "prefix_route" => [
                'required', Rule::notIn(
                    Invitation::where('prefix_route', $this->prefix_route)->where('expired_at', '<=', Carbon::now())->get()->toArray()
                )
            ],
            "phone" => "nullable",
            "customer_name" => "nullable|min:5",
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
