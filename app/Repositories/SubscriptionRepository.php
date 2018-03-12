<?php

namespace App\Repositories;

use App\Models\Subscription;
use Czim\Repository\BaseRepository;

class SubscriptionRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    public function addSubscription($data)
    {
        return $this->model->insertGetId($data);
    }
}
