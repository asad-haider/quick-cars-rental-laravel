<?php

namespace App\Repositories;

use App\Models\Type;
use Czim\Repository\BaseRepository;

class TypeRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Type::class;
    }

    public function getAllTypes()
    {
        return $this->model->where('status', '=', '1')->get();
    }
}
