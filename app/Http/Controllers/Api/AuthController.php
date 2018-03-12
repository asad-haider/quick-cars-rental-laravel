<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\ChangePasswordWithTokenRequest;
use App\Http\Requests\Api\ForgotPasswordCodeRequest;
use App\Http\Requests\Api\GuestLoginRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\LogoutRequest;
use App\Http\Requests\Api\RegistationRequest;
use App\Http\Requests\Api\UpdateForgotPasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Repositories\UdeviceRepository;
use App\Repositories\UserRepository;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

/*use App\Models\User;*/


class AuthController extends ApiBaseController
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected $userRepository, $uDevice;

    public function __construct(UserRepository $userRepository, UdeviceRepository $udevice)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->uDevice = $udevice;
    }

    public function register(RegistationRequest $request)
    {
        try {
            $postData = $request->all();
            $postData['name'] = $request->name;
            $postData['fname'] = $request->fname;
            $postData['lname'] = $request->lname;
            $postData['email'] = $request->email;
            $postData['password'] = bcrypt($request->password);
            $user = $this->userRepository->create($postData);    //set user data
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            $token = JWTAuth::attempt($credentials);
            $userById = $this->userRepository->find($user->id);
            return RESTAPIHelper::response(['user' => $userById], 200, 'Registered successfully.', $this->isBlocked, $token);

        } catch (\Exception $e) {
            return RESTAPIHelper::response([], 500, $e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        /*Check if token exits , deleted from user devices table*/
//        if ($this->uDevice->getByDeviceToken($request->device_token)) {
//            $this->uDevice->deleteByDeviceToken($request->device_token);
//        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return RESTAPIHelper::response([], 401, 'Invalid Credentials');
            }
            $user = JWTAuth::authenticate($token);
            $postData['user_id'] = $user->id;


//            $postData['device_type'] = $request->device_type;
//            $postData['device_token'] = $request->device_token;
//            $this->uDevice->create($postData);
            /*Check User Status*/

//            $this->getUserBlockedStatus($request->user_id);
            return RESTAPIHelper::response(['user' => $user], 200, 'Login successfully.', $this->isBlocked, $token);
        } catch (JWTException $e) {
            return RESTAPIHelper::response([], 500, 'could_not_create_token');
        }
    }

    public function guestLogin(GuestLoginRequest $request)
    {
        try {
            /*   $mytime = Carbon::now();
               $str = $mytime->toDateTimeString();
               $uniqueString = str_replace([' ', '-', ':'], '', $str) . \Illuminate\Support\Str::random(5);

               $postData = $request->all();
               $postData['name'] = 'Guest';
               $postData['email'] = 'guest' . $uniqueString . '@architecture.com';
               $postData['password'] = bcrypt($uniqueString);
               $postData['role_id'] = recursive_array_search('user', Config::get('constants.roles'));
               $postData['is_verified'] = 1;
               $postData['is_guest'] = 1;

               $user = $this->user->create($postData);

               if ($this->uDevice->getByDeviceToken($request->device_token)) {

                   $this->uDevice->deleteByDeviceToken($request->device_token);
               }

               $deviceData['user_id'] = $user->id;
               $deviceData['device_token'] = $request->device_token;;
               $deviceData['device_type'] = $request->device_type;

               $this->uDevice->create($deviceData);


               $credentials = [
                   'email' => $postData['email'],
                   'password' => $uniqueString,
                   'is_verified' => 1
               ];
               $token = JWTAuth::attempt($credentials);
               $userById = $this->user->find($user->id);*/

            /*******************************************Guest Login********************************************************/
            /*******************************************Guest Login********************************************************/
            /*******************************************Guest Login********************************************************/
            /*******************************************Guest Login********************************************************/


            $credentials = [
                'email' => Config::get('constants.guest.email'),
                'password' => Config::get('constants.guest.password')
            ];
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                $credentials['password'] = bcrypt($credentials['password']);
                $guest = $this->userRepository->create($credentials);
                if ($guest) {
                    $credentials['password'] = Config::get('constants.guest.password');
                    $token = JWTAuth::attempt($credentials);
                } else {
                    return RESTAPIHelper::response([], 404, 'Cannot login as guest');
                }

            }

            return RESTAPIHelper::response([], 200, 'Guest Login Successfully', $this->isBlocked, $token);

        } catch (\Exception $e) {
            return RESTAPIHelper::response([], 500, $e->getMessage());
        }


    }

    public function logout(LogoutRequest $request)
    {
//        $postData = $request->all();
        /*Check if token exits , deleted from user devices table*/
        try {
            JWTAuth::invalidate($request->bearerToken());
//            if ($this->uDevice->getByDeviceToken($request->device_token)) {
//                $this->uDevice->deleteByDeviceToken($request->device_token);
//            }
            return RESTAPIHelper::response([], 200, "Logout Successfully");
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return RESTAPIHelper::response([], 500, 'Error');
        }
    }

    public function getForgotPasswordCode(ForgotPasswordCodeRequest $request)
    {

        $user = $this->userRepository->getByEmail($request->email);
        if (!$user) {


            $error_message = "Your email address was not found.";
            return RESTAPIHelper::response([], 404, $error_message);
        }


        $code = rand(1111, 9999);

        $subject = "Forgot Password Verfication Code";
        try {
            $email = $user->email;
            $name = $user->name;

            $check = DB::table('password_resets')->where('email', $email)->first();
            if ($check) {
                DB::table('password_resets')->where('email', $email)->delete();
            }

            DB::table('password_resets')->insert(['email' => $email, 'code' => $code]);
            Mail::send('email.verify', ['name' => $user->name, 'verification_code' => $code],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('FROM_EMAIL_ADDRESS'), "From Education-USA");
                    $mail->to($email, $name);
                    $mail->subject($subject);

                });

        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return RESTAPIHelper::response([], 404, $error_message);
        }

        return RESTAPIHelper::response([], 200, 'Verification Code Send To Your Email');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $code = $request->verification_code;

        $check = DB::table('password_resets')->where('code', $code)->first();
        if (!is_null($check)) {
            $data['email'] = $check->email;
            $data['code'] = "valid";
            DB::table('password_resets')->where('code', $check->email)->delete();
            return RESTAPIHelper::response(['user' => $data]);
        } else {
            return RESTAPIHelper::response([], 404, 'Code Is Invalid');
        }
    }

    public function updateForgotPassword(UpdateForgotPasswordRequest $request)
    {
        $postData['password'] = bcrypt($request->password);

        try {
            $data = $this->userRepository->getByEmail($request->email);
            $this->userRepository->update($postData, $data->id);

            return RESTAPIHelper::response([], 200, 'Password Changed');
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return RESTAPIHelper::response([], 404, $error_message);
        }
    }

    public function changePassword(ChangePasswordWithTokenRequest $request)
    {
        $user = JWTAuth::authenticate($request->bearerToken());
        $postData['password'] = bcrypt($request->password);
        try {
            $this->userRepository->update($postData, $user->id);
            return RESTAPIHelper::response([], 200, 'Password Changed Successfully!');
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return RESTAPIHelper::response([], 404, $error_message);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = JWTAuth::authenticate($request->bearerToken());
            $postData = [];
            $postData['name'] = $request->name;
            $postData['fname'] = $request->fname;
            $postData['lname'] = $request->lname;
            $postData['phone'] = $request->phone;
            $postData['city'] = $request->city;
            $postData['country'] = $request->country;

            $this->userRepository->update($postData, $user->id);
            $userById = $this->userRepository->find($user->id);
            return RESTAPIHelper::response(['user' => $userById], 200, 'Profile updated successfully!');
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return RESTAPIHelper::response([], 404, $error_message);
        }
    }

    /*  public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token', $verification_code)->first();

        if (!is_null($check)) {
            $user = User::find($check->user_id);
            if ($user->is_verified == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified..'
                ]);
            }
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token', $verification_code)->delete();
            return response()->json([
                'success' => true,
                'message' => 'You have successfully verified your email address.'
            ]);
        }

        return response()->json(['success' => false, 'error' => "Verification code is invalid."]);
    }*/


    /* public function recover(Request $request)
     {
         $user = User::where('email', $request->email)->first();
         if (!$user) {
             $error_message = "Your email address was not found.";
             return response()->json(['success' => false, 'error' => ['email' => $error_message]], 401);
         }
         try {
             Password::sendResetLink($request->only('email'), function (Message $message) {
                 $message->subject('Your Password Reset Link');
             });

         } catch (\Exception $e) {
             //Return with error
             $error_message = $e->getMessage();
             return response()->json(['success' => false, 'error' => $error_message], 401);
         }
         return response()->json([
             'success' => true, 'data' => ['msg' => 'A reset email has been sent! Please check your email.']
         ]);
     }*/


}