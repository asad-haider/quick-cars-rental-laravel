<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * CheckPermission constructor.
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $permission
     * @return mixed
     */



    public function handle($request, Closure $next)
    {
        if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {
            if (Auth::user()->checkUserHasAccess(Auth::user()->id, $request->route()->getName())) {
                return $next($request);
            }
        }
        return response('Unauthorized.', 401);
//        return $request->ajax ? response('Unauthorized.', 401) : redirect('/login');
    }
}