<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Http\Controllers\Controller;
use App\Repositories\TypeRepository;

class TypeController extends Controller
{
    protected $typeRepository;

    /**
     * BrandController constructor.
     * @param TypeRepository $typeRepository
     */
    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getAllTypes()
    {
        return RESTAPIHelper::response($this->typeRepository->getAllTypes());
    }
}
