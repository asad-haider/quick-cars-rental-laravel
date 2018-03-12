<?php

namespace App\Http\Requests\Api;
use App\Helpers\RESTAPIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LogoutRequest extends FormRequest
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
//             'device_token' => 'required',
        ];
    }
}
