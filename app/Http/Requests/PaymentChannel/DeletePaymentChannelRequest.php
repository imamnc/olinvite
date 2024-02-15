<?php

namespace App\Http\Requests\PaymentChannel;

use App\Models\PaymentChannel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class DeletePaymentChannelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required_without:selected_id', Rule::exists('payment_channels', 'id')],
            'selected_id' => ['required_without:id', 'array', Rule::in(PaymentChannel::onlyTrashed()->get()->pluck('id')->toArray())],
            'force' => ['nullable', 'in:true,false']
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
