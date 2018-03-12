<?php

namespace App\Repositories;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use Czim\Repository\BaseRepository;
use Illuminate\Support\Facades\Config;
use Ramsey\Uuid\Uuid;

class UserRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getTotalUsersCount()
    {
        return $this->model->count();
    }

    public function getUsersCountByConfirmation($confirmed)
    {
        return $this->model->where('confirmed', $confirmed)->count();
    }

    public function getUsersCountByActivation($active)
    {
        return $this->model->where('active', $active)->count();
    }

    public function getUsersCountByProvider($provider = null)
    {
        if (isset($provider)) {
            return $this->model->whereHas('providers', function ($query) use ($provider) {
                $query->where('provider', $provider);
            })->count();
        } else {
            return $this->model->whereDoesntHave('providers')->count();
        }
    }

    public function getUsersWithRoles()
    {
        return $this->model->with('roles');
    }

    public function getUserById($userId)
    {
        return $this->model->with('roles')->where('id', '=', $userId)->first();
    }

    public function getUsersWithRolesAndProtectionValidation()
    {
        return $this->model->with(['roles', 'protectionValidation'])->sortable(['email' => 'asc'])->paginate();
    }

    public function createUser($data)
    {
        $user = $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => Uuid::uuid4(),
            'confirmed' => false
        ]);

        if (config('auth.users.default_role')) {
            $user->roles()->attach(Role::firstOrCreate(['name' => config('auth.users.default_role')]));
        }
        return $user;
    }

    public function getUserByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    public function getUsersByDeviceType($type)
    {
        $role_id = recursive_array_search('Administrator', Config::get('constants.roles'));
        if ($type == "all") {
            $data = $this->model->select('users.id', 'users.name', 'user_devices.device_token', 'user_devices.device_type')
                ->join('user_devices',
                    function ($join) {
                        $join->on('users.id', '=', 'user_devices.user_id');
                    })
                ->join('users_roles',
                    function ($join) {
                        $join->on('users.id', '=', 'users_roles.user_id');
                    })
                ->where('users_roles.role_id', '<>', $role_id)
                ->get();
        } else {
            $data = $this->model->select('users.id', 'users.name', 'user_devices.device_token', 'user_devices.device_type')
                ->join('user_devices',
                    function ($join) {
                        $join->on('users.id', '=', 'user_devices.user_id');
                    })
                ->join('users_roles',
                    function ($join) {
                        $join->on('users.id', '=', 'users_roles.user_id');
                    })
                ->where('user_devices.device_type', '=', $type)
                ->where('users_roles.role_id', '<>', $role_id)
                ->get();
        }
        return $data;
    }
}
