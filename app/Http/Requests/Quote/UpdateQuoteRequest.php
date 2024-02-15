<?php

namespace App\Http\Requests\Quote;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateQuoteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('quotes', 'id')],
            'title' => ['required', 'min:5', Rule::unique('quotes')->ignore($this->id)],
            'content' => ['required', 'min:10', Rule::unique('quotes')->ignore($this->id)],
            'from' => ['required', 'min:3', Rule::unique('quotes')->ignore($this->id)]
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
