<?php

/**
 * Global helpers file with misc functions.
 */

use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Config;

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     *
     * @return \Creativeorange\Gravatar\Gravatar|\Illuminate\Foundation\Application|mixed
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('to_js')) {
    /**
     * Access the javascript helper.
     */
    function to_js($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('tojs');
        }

        if (is_array($key)) {
            return app('tojs')->put($key);
        }

        return app('tojs')->get($key, $default);
    }
}

if (!function_exists('meta')) {
    /**
     * Access the meta helper.
     */
    function meta()
    {
        return app('meta');
    }
}

if (!function_exists('meta_tag')) {
    /**
     * Access the meta tags helper.
     */
    function meta_tag($name = null, $content = null, $attributes = [])
    {
        return app('meta')->tag($name, $content, $attributes);
    }
}

if (!function_exists('meta_property')) {
    /**
     * Access the meta tags helper.
     */
    function meta_property($name = null, $content = null, $attributes = [])
    {
        return app('meta')->property($name, $content, $attributes);
    }
}

if (!function_exists('protection_context')) {
    /**
     * @return \NetLicensing\Context
     */
    function protection_context()
    {
        return app('netlicensing')->context();
    }
}

if (!function_exists('protection_context_basic_auth')) {
    /**
     * @return \NetLicensing\Context
     */
    function protection_context_basic_auth()
    {
        return app('netlicensing')->context(\NetLicensing\Context::BASIC_AUTHENTICATION);
    }
}

if (!function_exists('protection_context_api_key')) {
    /**
     * @return \NetLicensing\Context
     */
    function protection_context_api_key()
    {
        return app('netlicensing')->context(\NetLicensing\Context::APIKEY_IDENTIFICATION);
    }
}

if (!function_exists('protection_shop_token')) {

    /**
     * @param \App\Models\Auth\User\User $user
     * @param null $successUrl
     * @param null $cancelUrl
     * @param null $successUrlTitle
     * @param null $cancelUrlTitle
     * @return \App\Models\Protection\ProtectionShopToken
     */
    function protection_shop_token(\App\Models\Auth\User\User $user, $successUrl = null, $cancelUrl = null, $successUrlTitle = null, $cancelUrlTitle = null)
    {
        return app('netlicensing')->createShopToken($user, $successUrl, $cancelUrl, $successUrlTitle, $cancelUrlTitle);
    }
}

if (!function_exists('protection_validate')) {

    /**
     * @param \App\Models\Auth\User\User $user
     * @return \App\Models\Protection\ProtectionValidation
     */
    function protection_validate(\App\Models\Auth\User\User $user)
    {
        return app('netlicensing')->validate($user);
    }
}


function sendPushNotifications($msg = 'Project Name', $deviceObject = [])
{

    $deviceTokenAndroid = [];
    $deviceTokenIphone = [];

    foreach ($deviceObject as $device):
        if ($device['device_type'] == 'android') {
            $deviceTokenAndroid[] = $device['device_token'];
        } else {
            $deviceTokenIphone[] = $device['device_token'];
        }
    endforeach;

    if ($deviceTokenAndroid) {
        $push = new PushNotification('fcm');
        $push->setMessage([
            'title' => config('app.name'),
            'message' => $msg])
            ->setApiKey(Config::get('constants.pushNotification.fcm'))
            ->setConfig(['dry_run' => false])
            ->setDevicesToken($deviceTokenAndroid)
            ->send();
    }

    /*Apn*/
    if ($deviceTokenIphone) {
        $push = new PushNotification('apn');

        $push->setMessage([
            'aps' => [
                'alert' => [
                    'title' => config('app.name'),
                    'body' => $msg
                ],
                'sound' => 'default'
            ]
        ])
            ->setDevicesToken($deviceTokenIphone)
            ->send();
    }

    return true;
}

function recursive_array_search($needle, $haystack)
{
    foreach ($haystack as $key => $value) {
        $current_key = $key;
        if ($needle === $value OR (is_array($value) && recursive_array_search($needle, $value) !== false)) {
            return $current_key;
        }
    }
    return false;
}