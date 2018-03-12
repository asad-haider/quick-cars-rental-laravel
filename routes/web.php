<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Image resize
 */

//Route::get('/resize/{img_dir}/{img}/{h?}/{w?}', function ($img_dir, $img, $h = '', $w = '') {
//    ob_end_clean();
//    try {
//        $storagePath = storage_path("app\\$img_dir\\$img");
//        if ($h && $w) {
//            return Image::make($storagePath)->resize($h, $w, function ($c) {
//                $c->aspectRatio();
//                $c->upsize();
//            })->response();
//        } else {
//            return Image::make($storagePath)->response();
//        }
//    } catch (\Exception $e) {
//        return \App\Helpers\RESTAPIHelper::response([], 500, $e->getMessage());
//    }
//});

Route::get('/resize/{img_dir}/{img}/{h?}/{w?}', function ($img_dir, $img, $h = '', $w = '') {
    ob_end_clean();
    try {
        if ($h && $w) {
            return Image::make(asset("storage/app/$img_dir/$img"))->resize($h, $w, function ($c) {
            })->response('png');
        } else {
            return response(file_get_contents(asset("storage/app/$img_dir/$img")))
                ->header('Content-Type', 'image/png');
        }
    } catch (\Exception $e) {
        return \App\Helpers\RESTAPIHelper::response([], 500, $e->getMessage());
    }
});


/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth', 'prefix' => 'admin'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['admin', 'acl']], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users-data', 'UserController@getDataTable')->name('users-data');
    Route::get('users/{user}', 'UserController@show')->name('users.show');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('users/users-type/{type}', 'UserController@getUsersByDeviceType')->name('users.get_by_type');

    Route::get('dashboard/log-chart', 'DashboardController@getLogChartData')->name('dashboard.log.chart');
    Route::get('dashboard/registration-chart', 'DashboardController@getRegistrationChartData')->name('dashboard.registration.chart');

    // Notifications
    Route::get('notifications/create', 'NotificationController@index')->name('notifications.index');
    Route::post('notifications/store', 'NotificationController@store')->name('notifications.send_notification');

    // Roles
    Route::get('roles', 'RoleController@index')->name('roles');
    Route::get('roles-data', 'RoleController@getDataTable')->name('roles-data');
    Route::get('roles/{role}', 'RoleController@show')->name('roles.show');
    Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit');
    Route::put('roles/{role}', 'RoleController@update')->name('roles.update');
    Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy');
});


Route::get('/', 'HomeController@index')->name('home');