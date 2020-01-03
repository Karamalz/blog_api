<?php

namespace App\Http\Requests;

use App\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'catagory' => ['required'],
            'content' => ['required', 'max:255', 'regex:/^[A-Za-z0-9?., ]+$/']
        ];
    }
}
