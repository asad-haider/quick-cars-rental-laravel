<?php

namespace App\Repositories;

use App\Models\Listing;
use Czim\Repository\BaseRepository;

class ListingRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Listing::class;
    }

    public function getListingsByPagination($category_id, $brand_id)
    {
        $query = $this->model
            ->with(['features' => function ($query) {
                $query->take(5);
            }])
            ->where([['status', '=', '1']]);

        if (isset($category_id) && $category_id != 'undefined' && $category_id != 'null')
            $query->where('category_id', '=', $category_id);
        if (isset($brand_id) && $brand_id != 'undefined' && $brand_id != 'null')
            $query->where('brand_id', '=', $brand_id);

        return $query->paginate(6);
        //  ->paginate(Config::get('constants.limit'));
    }

    public function getFeaturedListings()
    {
        return $this->model
            ->with(['features' => function ($query) {
                $query->take(5);
            }])
            ->with(['category'])
            ->where([['status', '=', '1']])
            ->take(10)->get();
    }

    public function getListingById($id)
    {
        return $this->model
            ->with(['category', 'type', 'brand', 'features', 'extras'])
            ->where([['status', '=', '1'], ['id', '=', $id]])
            ->first();
    }
}
