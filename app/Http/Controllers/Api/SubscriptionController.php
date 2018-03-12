<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RESTAPIHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $subscriptionRepository;

    /**
     * SubscriptionController constructor.
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function addSubscription(SubscriptionRequest $request)
    {
        $data = $request->all();
        $data["created_at"] = Carbon::now();
        $data["updated_at"] = Carbon::now();
        return RESTAPIHelper::response($this->subscriptionRepository->addSubscription($data));
    }
}
