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
            "theme_id" => "required|numeric",
            "prefix_route" => [
                'required', Rule::notIn(
                    Invitation::where('prefix_route', strtolower($this->prefix_route))->where(function ($sub1) {
                        $sub1->whereNull('expired_at');
                        $sub1->orWhere(function ($sub2) {
                            $sub2->whereNotNull('expired_at')->where('expired_at', '<=', Carbon::now()->toDateTimeString());
                        });
                    })->get()->pluck('prefix_route')
                )
            ],
            "customer_name" => "required|min:5",
            "phone" => "required|numeric",
            "email" => "nullable|email"
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
