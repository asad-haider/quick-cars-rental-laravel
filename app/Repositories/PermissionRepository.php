<?php

namespace App\Repositories;

use App\Models\Permission;
use Czim\Repository\BaseRepository;

class PermissionRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    public function getPermissionsByUser($userId)
    {
        return $this->model
            ->select('permissions.permission_slug')
            ->join('permissions_roles as pr', function ($join) {
                $join->on('pr.permission_id', '=', 'permissions.id');
            })
            ->join('users_roles as ur', function ($join) {
                $join->on('pr.role_id', '=', 'ur.role_id');
            })
            ->where('ur.user_id', '=', $userId)
            ->distinct()
            ->get();
    }
}
