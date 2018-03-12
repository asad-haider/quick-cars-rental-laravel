<?php

namespace App\Helpers;

class RESTAPIHelper
{

    public static function response($output = array(), $code = 200, $message = 'Success', $isBlocked = 0, $authToken = '', $pages = 0, $format = 'json')
    {
        $response['Message'] = $message;
        $response['Code'] = $code;
        $response['Result'] = ($output) ? $output : new \stdClass();
        $response['UserBlocked'] = $isBlocked;
        $response['token'] = $authToken;
        $response['pages'] = $pages;

        return response($response, $code);
    }

    public static function emptyResponse($status = true, $dev_message = '', $format = 'json')
    {
        $response = [
            'status' => $status,
            'error_code' => $dev_message
        ];

        return response()->json($response);
    }

}
