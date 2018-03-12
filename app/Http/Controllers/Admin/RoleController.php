<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Auth\Role\Role;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        return view('admin.roles.index');
    }

    public function getDataTable()
    {
        $roles = $this->roleRepository->getRoles();
        return Datatables::of($roles)
            ->addColumn('action', function ($role) {
                $actionColumn = '<a class="btn btn-xs btn-primary" href="' . route('admin.roles.show', [$role->id]) . '" 
                data-toggle="tooltip" data-placement="top" data-title="' . __('views.admin.roles.index.show') . '">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-xs btn-info" href="' . route('admin.roles.edit', [$role->id]) . '" data-toggle="tooltip"
                    data-placement="top" data-title="' . __('views.admin.roles.index.edit') . '">
                    <i class="fa fa-pencil"></i>
                </a>';
                return $actionColumn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', ['role' => $role]);
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', ['role' => $role, 'permissions' => $this->permissionRepository->all()]);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->name = $request->get('name');
        $role->save();

        //roles
        if ($request->has('permissions')) {
            $role->permissions()->detach();

            if ($request->get('permissions')) {
                $role->permissions()->attach($request->get('permissions'));
            }
        }

        return redirect()->intended(route('admin.roles'));
    }

    public function destroy($id)
    {
        //
    }
}
