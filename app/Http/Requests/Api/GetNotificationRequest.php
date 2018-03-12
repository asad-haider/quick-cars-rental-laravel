<?php

namespace App\Http\Requests\Api;

use App\Helpers\RESTAPIHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class GetNotificationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    protected function failedValidation(Validator $validator) {
        $response = RESTAPIHelper::response([],404,$validator->errors()->first());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'ref_id' => 'required',
            'notification_id' => 'required|exists:notifications,id',
            'action_type' => 'required'
        ];
    }
}
