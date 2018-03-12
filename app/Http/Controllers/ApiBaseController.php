<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;


class ApiBaseController extends Controller
{
    protected $isBlocked = 0;
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = App::make(UserRepository::class);
    }

    protected function getUserBlockedStatus($user_id)
    {
        if ($this->userRepository->getUserStatus($user_id) == 0) {
            $this->isBlocked = 1;
        }
    }
}
