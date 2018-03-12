<?php

namespace App\Repositories;

use App\Models\Notification;
use Czim\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository
{

    public function model()
    {
        return Notification::class;
    }

    public function getByReceiverId($receiver_id)
    {
        return $this->model->select('id as notification_id', 'receiver_id', 'text', 'action_type', 'read', 'ref_id', 'created_at')->where('receiver_id', $receiver_id)->get();
    }

    public function setData($data)
    {
        $notification = $this->model->create($data);
        $notification->users()->attach($data['users']);
        return $notification;
    }

    public function getUnsentNotifications()
    {
        $id = Auth::id();
        $data = $this->model->select('users.email', 'notifications.message', 'notifications.url', 'notifications.added_by', 'notification_user.notification_id', 'notification_user.user_id')
            ->join('notification_user', function ($join) {
                $join->on('notifications.id', '=', 'notification_user.notification_id')
                    ->where('notification_user.is_sent', '=', 0);
            })
            ->join('users', function ($join) {
                $join->on('notification_user.receiver_id', '=', 'users.id');
            })
            ->where('notifications.sender_id', '=', $id)
            //->where('notification_user.is_sent', '=', 0)
            ->get();
        return $data;
    }

    public function changeNotificationStatus($notification_id, $user_id, $attributes)
    {
        return $this->model->find($notification_id)->users()->updateExistingPivot($user_id, $attributes);
    }

    /*public function BulkCreateNotificaitons($data) {
        return $this->model->insert($data);
    }*/


    /*For Api*/
    /*public function getByReceiverId($receiver_id) {
        return $this->model->select('id as notification_id','receiver_id','text','action_type','read','ref_id','created_at')
            ->where('receiver_id',$receiver_id)
            ->orderBy('created_at','desc')
            ->get();
    }*/

}
