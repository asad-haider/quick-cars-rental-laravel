<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    return 'working';
});

Route::post('guest-login', 'Api\AuthController@guestLogin');
Route::post('login', 'Api\AuthController@login');
Route::post('verify-code', 'Api\AuthController@verifyCode');
Route::post('resend-code', 'Api\AuthController@resendCode');
Route::post('create-profile', 'Api\AuthController@createProfile');

Route::get('email-password-code', 'Api\AuthController@getForgotPasswordCode');
Route::post('register', 'Api\AuthController@register');
Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');


Route::group(['middleware' => ['jwt.customAuth']], function () {

    Route::post('logout', 'Api\AuthController@logout');
    Route::post('updateProfile', 'Api\AuthController@updateProfile');
    Route::post('changePassword', 'Api\AuthController@changePassword');

    Route::get('/auth-test', function (Request $request) {
        return ($request->user_id);
    });
});

// Quick Cars Rental Routes
Route::get('types', 'Api\TypeController@getAllTypes');
Route::get('categories', 'Api\CategoryController@getAllCategories');
Route::get('brands', 'Api\BrandController@getAllBrands');
Route::get('listings', 'Api\ListingController@getListings');
Route::get('listings/featured', 'Api\ListingController@getFeaturedListings');
Route::get('listing/{id}', 'Api\ListingController@getListingById');
Route::get('news', 'Api\NewsController@getNews');
Route::get('news/featured', 'Api\NewsController@getFeaturedNews');
Route::get('news/{id}', 'Api\NewsController@getNewsById');
Route::post('subscribe', 'Api\SubscriptionController@addSubscription');

