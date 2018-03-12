<?php
/**
 * Created by PhpStorm.
 * User: syedasadhaider
 * Date: 2/3/2018
 * Time: 11:54 AM
 */

namespace App\Http\Controllers;

use function App\Helper\recursive_array_search;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;


class ViewBaseController extends Controller
{

    /**
     * ViewBaseController constructor.
     */

    protected $userRepository;

    public function __construct()
    {
//        $this->userRepository = App::make(UserRepository::class);
//
//        $this->middleware(function ($request, $next) {
//            $role_id = $request->session()->get('user_detail')->role_id;
//            $modules = null;
//            if ($role_id == recursive_array_search('admin', Config::get('constants.roles'))) {
//                $modules = array(
//                    "users" => ['count' => $this->userRepository->getUsersCount(), 'icon' => "fa fa-users", 'bg' => "green"]
//                );
//            }
//            $title = Config::get('constants.roles')[$role_id]['title'] . ' Dashboard';
//            View::share('title', $title);
//            View::share('modules', $modules);
//            return $next($request);
//        });
    }
}