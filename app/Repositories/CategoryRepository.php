<?php

namespace App\Repositories;

use App\Models\Category;
use Czim\Repository\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getAllCategories()
    {
        return $this->model->where('status', '=', '1')->get();
    }
}
