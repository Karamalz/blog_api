<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class articleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:255', 'regex:/^[A-Za-z0-9?., ]+$/'],
            'catagory' => ['required', 'in:Laravel, PHP, MySQL, C++, Vuejs, Else'],
            'content' => ['required', 'max:255', 'regex:/^[A-Za-z0-9?., ]+$/'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $errors,
                'data' => '',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
