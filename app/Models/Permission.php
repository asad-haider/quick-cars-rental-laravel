<?php

namespace App\Models;

use App\Models\Auth\Role\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
