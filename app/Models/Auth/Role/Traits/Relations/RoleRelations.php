<?php

namespace App\Models\Auth\Role\Traits\Relations;

use App\Models\Auth\User\User;
use App\Models\Permission;

trait RoleRelations
{
    /**
     * Relation with users
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles', 'role_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles', 'role_id', 'permission_id');
    }
}
