<?php

namespace App\Repositories;

use App\Models\Auth\Role\Role;
use Czim\Repository\BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    public function getRoles()
    {
        return $this->model->get();
    }
}
