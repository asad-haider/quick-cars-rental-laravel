<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Http\Controllers\Controller;
use App\Repositories\ListingRepository;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    protected $listingRepository;

    /**
     * ListingRepository constructor.
     * @param ListingRepository $listingRepository
     */
    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    public function getListings(Request $request)
    {
        return RESTAPIHelper::response($this->listingRepository->getListingsByPagination($request->get('category_id'), $request->get('brand_id')));
    }

    public function getFeaturedListings()
    {
        return RESTAPIHelper::response($this->listingRepository->getFeaturedListings());
    }

    public function getListingById($id)
    {
        return RESTAPIHelper::response($this->listingRepository->getListingById($id));
    }
}
