<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{

    protected $brandRepository;

    /**
     * BrandController constructor.
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands() {
        return RESTAPIHelper::response($this->brandRepository->getAllBrands());
    }
}
