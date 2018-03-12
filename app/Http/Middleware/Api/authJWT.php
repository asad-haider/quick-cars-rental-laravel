<?php

namespace App\Http\Middleware\Api;

use App\Helpers\RESTAPIHelper;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\GetUserFromToken;

class authJWT extends GetUserFromToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return RESTAPIHelper::response([], 401, 'Token not provided');
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            // If the token is expired, then it will be refreshed and added to the headers
            try {
                $refreshed = $this->auth->refresh($this->auth->getToken());
                $user = $this->auth->setToken($refreshed)->toUser();
                header("Authorization: $refreshed");
            } catch (JWTException $e) {
                return RESTAPIHelper::response([], 401, 'Token expired.');
            }
        } catch (JWTException $e) {
            return RESTAPIHelper::response([], 401, 'Invalid token.');
        }

        if (!$user) {
            return RESTAPIHelper::response([], 404, 'User not found');
        }

        $this->events->fire('tymon.jwt.valid', $user);
        $request->request->add(['user_id' => $user['id']]);
        $request['user_id'] = $user['id'];
        return $next($request);
    }
}

