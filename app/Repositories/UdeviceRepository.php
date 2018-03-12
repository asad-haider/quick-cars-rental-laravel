<?php

namespace App\Repositories;

use Czim\Repository\BaseRepository;
use App\Models\UserDevice;

class UdeviceRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserDevice::class;
    }

    /***********************************************API***********************************************/

    /*Old Functions */

    public function getByDeviceToken($data){

        return $this->model->where('device_token',$data)->get();

    }
    public function deleteByDeviceToken($data){
        return $this->model->where('device_token',$data)->delete();
    }

}
