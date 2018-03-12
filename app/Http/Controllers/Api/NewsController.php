<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Http\Controllers\Controller;
use App\Repositories\NewsRepository;

class NewsController extends Controller
{
    protected $newsRepository;

    /**
     * NewsController constructor.
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getNews()
    {
        return RESTAPIHelper::response($this->newsRepository->getNewsByPagination());
    }

    public function getFeaturedNews()
    {
        return RESTAPIHelper::response($this->newsRepository->getFeaturedNews());
    }

    public function getNewsById($id)
    {
        return RESTAPIHelper::response($this->newsRepository->getNewsById($id));
    }
}
