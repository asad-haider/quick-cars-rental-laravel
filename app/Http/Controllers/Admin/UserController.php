<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    protected $userRepository;
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function getDataTable()
    {
        $users = $this->userRepository->getUsersWithRoles();
        return Datatables::of($users)
            ->editColumn('roles', function ($user) {
                return $user->roles->pluck('name')->implode(',');
            })
            ->editColumn('active', function ($user) {
                if ($user->active)
                    return '<span class="label label-primary">' . __('views.admin.users.index.active') . '</span>';
                else
                    return '<span class="label label-danger">' . __('views.admin.users.index.inactive') . '</span>';
            })
            ->editColumn('confirmed', function ($user) {
                if ($user->confirmed)
                    return '<span class="label label-success">' . __('views.admin.users.index.confirmed') . '</span>';
                else
                    return '<span class="label label-warning">' . __('views.admin.users.index.not_confirmed') . '</span>';
            })
            ->addColumn('action', function ($user) {

                $actionColumn = '<a class="btn btn-xs btn-primary" href="' . route('admin.users.show', [$user->id]) . '" 
                data-toggle="tooltip" data-placement="top" data-title="' . __('views.admin.users.index.show') . '">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-xs btn-info" href="' . route('admin.users.edit', [$user->id]) . '" data-toggle="tooltip"
                    data-placement="top" data-title="' . __('views.admin.users.index.edit') . '">
                    <i class="fa fa-pencil"></i>
                </a>';

                /*if (!$user->hasRole('administrator')) {
                    $actionColumn .= '<button class="btn btn-xs btn-danger user_destroy"
                            data-url="' . route('admin.users.destroy', [$user->id]) . '" data-toggle="tooltip"
                            data-placement="top" data-title="' . __('views.admin.users.index.delete') . '">
                        <i class="fa fa-trash"></i>
                    </button>';
                }*/

                return $actionColumn;
            })
            ->rawColumns(['active', 'confirmed', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'roles' => $this->roleRepository->all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'active' => 'sometimes|boolean',
            'confirmed' => 'sometimes|boolean',
        ]);

        $validator->sometimes('email', 'unique:users', function ($input) use ($user) {
            return strtolower($input->email) != strtolower($user->email);
        });

        $validator->sometimes('password', 'min:6|confirmed', function ($input) {
            return $input->password;
        });

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->active = $request->get('active', 0);
        $user->confirmed = $request->get('confirmed', 0);

        $user->save();

        //roles
        if ($request->has('roles')) {
            $user->roles()->detach();

            if ($request->get('roles')) {
                $user->roles()->attach($request->get('roles'));
            }
        }

        return redirect()->intended(route('admin.users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUsersByDeviceType($type)
    {
        $user = $this->userRepository->getUsersByDeviceType($type);
        return $user;
    }

}
