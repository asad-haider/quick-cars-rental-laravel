<?php

namespace App\Http\Requests\Api;

use App\Helpers\RESTAPIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends FormRequest
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
            'user_id' => 'required',
            'old_password' => 'required',
            'password' => 'required|different:old_password'

        ];
    }
    public function messages()
    {
        return [
            'password.old_password' => 'The Password And The Old Password Must Be Different'
        ];
    }
}
