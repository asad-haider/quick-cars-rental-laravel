<?php

namespace App\Repositories;

use App\Models\News;
use Czim\Repository\BaseRepository;

class NewsRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return News::class;
    }

    public function getNewsByPagination()
    {
        $query = $this->model
            ->selectRaw('id, title, banner_image, status, created_at, updated_at, IF(LENGTH(description) > 50,CONCAT(LEFT(description, 50), "..."), description) AS description')
            ->where([['status', '=', '1']]);
        return $query->paginate(6);
        //  ->paginate(Config::get('constants.limit'));
    }

    public function getFeaturedNews()
    {
        return $this->model
            ->selectRaw('id, title, banner_image, status, created_at, updated_at, IF(LENGTH(description) > 50,CONCAT(LEFT(description, 50), "..."), description) AS description')
            ->where([['status', '=', '1']])
            ->take(3)
            ->get();
    }

    public function getNewsById($id)
    {
        return $this->model
            ->where([['status', '=', '1'], ['id', '=', $id]])
            ->first();
    }
}
