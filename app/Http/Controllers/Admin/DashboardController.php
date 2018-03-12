<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use Arcanedev\LogViewer\Entities\Log;
use Arcanedev\LogViewer\Entities\LogEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $userRepository;
    protected $permissionRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counts = [
            'users' => $this->userRepository->getTotalUsersCount(),
            'users_unconfirmed' => $this->userRepository->getUsersCountByConfirmation(false),
            'users_inactive' => $this->userRepository->getUsersCountByActivation(false),
            'protected_pages' => 0,
        ];

        foreach (\Route::getRoutes() as $route) {
            foreach ($route->middleware() as $middleware) {
                if (preg_match("/protection/", $middleware, $matches)) $counts['protected_pages']++;
            }
        }

        $permissions = $this->permissionRepository->getPermissionsByUser(Auth::user()->id);
        return view('admin.dashboard', ['counts' => $counts, 'permissions' => $permissions]);
    }


    public function getLogChartData(Request $request)
    {
        \Validator::make($request->all(), [
            'start' => 'required|date|before_or_equal:now',
            'end' => 'required|date|after_or_equal:start',
        ])->validate();

        $start = new Carbon($request->get('start'));
        $end = new Carbon($request->get('end'));

        $dates = collect(\LogViewer::dates())->filter(function ($value, $key) use ($start, $end) {
            $value = new Carbon($value);
            return $value->timestamp >= $start->timestamp && $value->timestamp <= $end->timestamp;
        });


        $levels = \LogViewer::levels();

        $data = [];

        while ($start->diffInDays($end, false) >= 0) {

            foreach ($levels as $level) {
                $data[$level][$start->format('Y-m-d')] = 0;
            }

            if ($dates->contains($start->format('Y-m-d'))) {
                /** @var  $log Log */
                $logs = \LogViewer::get($start->format('Y-m-d'));

                /** @var  $log LogEntry */
                foreach ($logs->entries() as $log) {
                    $data[$log->level][$log->datetime->format($start->format('Y-m-d'))] += 1;
                }
            }

            $start->addDay();
        }

        return response($data);
    }

    public function getRegistrationChartData()
    {
        $data = [
            'registration_form' => $this->userRepository->getUsersCountByProvider(),
            'google' => $this->userRepository->getUsersCountByProvider('google'),
            'facebook' => $this->userRepository->getUsersCountByProvider('facebook'),
            'twitter' => $this->userRepository->getUsersCountByProvider('twitter')
        ];

        return response($data);
    }
}
