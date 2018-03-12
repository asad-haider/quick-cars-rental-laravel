<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\RESTAPIHelper;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
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


    protected function failedValidation(Validator $validator) {
        $response = RESTAPIHelper::response([],404,$validator->errors()->first());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'email' => 'required|email',
                'password' => 'required',
//                'device_type' => 'required',
//                'device_token' => 'required',

        ];
    }
}
