<?php

namespace App\Http\Requests\Api;

use App\Helpers\RESTAPIHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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


    protected function failedValidation(Validator $validator)
    {
        $response = RESTAPIHelper::response([], 404, $validator->errors()->first());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $error = [
            'name' => 'required|max:255',
            'fname' => 'max:100',
            'lname' => 'max:100',
            'phone' => 'max:20',
            'city' => 'max:50',
            'country' => 'max:50',
        ];
    }


}
