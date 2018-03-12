<?php

namespace App\Repositories;

use App\Models\Brand;
use Czim\Repository\BaseRepository;

class BrandRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Brand::class;
    }

    public function getAllBrands()
    {
        return $this->model->where('status', '=', '1')->get();
    }
}
