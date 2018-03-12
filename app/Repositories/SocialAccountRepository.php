<?php

namespace App\Repositories;

use App\Models\Auth\User\SocialAccount;
use Czim\Repository\BaseRepository;

class SocialAccountRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return SocialAccount::class;
    }

    public function getSocialAccountByProvider ($provider, $providerId){
        return SocialAccount::whereProvider($provider)
            ->whereProviderId($providerId)
            ->first();
    }
}
