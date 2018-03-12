<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ViewBaseController;
use App\Jobs\SendPushNotification;
use App\Repositories\NotificationRepository;
use App\Repositories\UdeviceRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends ViewBaseController
{

    protected $notification, $uDevices, $userRepository;

    public function __construct(NotificationRepository $notification, UdeviceRepository $uDevice, UserRepository $userRepository)
    {

        parent::__construct();
        $this->notification = $notification;
        $this->uDevices = $uDevice;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getUsersByDeviceType('all');
        return view('admin.notifications.send_notifications',
            [
                'module' => 'Notifications',
                'users' => $users,
                'deviceTypes' => ['android' => 'Android', 'ios' => 'IOS', 'all' => 'All']
            ]
        );
    }

    public function store(Request $request)
    {
        $notificationData = [];
        $pushNotificationData = [];
        $id = Auth::id();

        $notificationData['message'] = $request->message;
        $notificationData['sender_id'] = $id;
        $notificationData['action_type'] = 'general';
        $notificationData['users'] = [];

        foreach ($request['users'] as $key => $value):
            $value = json_decode($value, true);

            if (!in_array($value['id'], $notificationData['users'])) // distinct user's id
                $notificationData['users'][$key] = $value['id'];

            if ($request->device_type == 'all') {
                $pushNotificationData[] = $value;
            } else {
                $pushNotificationData[] = ['user_id' => $value['id'], 'device_type' => $value['device_type'], 'device_token' => $value['device_token']];
            }
        endforeach;

        /*Seed Notification Table*/
        $this->notification->setData($notificationData);

        /******************Queues push notifications jobs ***************************/
        $jobs = (new SendPushNotification($request->message, $pushNotificationData));
        $this->dispatch($jobs);
        //dispatch(new SendPushNotification($request->message, $pushNotificationData));
        //sendPushNotifications($request->message,$pushNotificationData);
//        Alert::success('Send Successfully');
        return Redirect::back();
    }
}
