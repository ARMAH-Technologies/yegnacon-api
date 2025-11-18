<?php

namespace App\Http\Controllers;

use App\Entities\Notification;
use App\Repositories\NotificationRepository;
use App\Transformers\NotificationTransformer;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationRepository;
    protected $perPage = 10;
    use Helpers;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = $this->notificationRepository->getAllNotifications($this->perPage);
//        return $notifications;

        $response = $this->response->collection($notifications, new NotificationTransformer());
        return $response;

    }

    public function findNotification($notification_id){
        $notification = Notification::find($notification_id);
        return $this->response->item($notification, new NotificationTransformer());
    }

    public function getUserNotifications($user_id)
    {
        $notifications = $this->notificationRepository->getUserNotifications($user_id, $this->perPage);

        $response = $this->response->collection($notifications, new NotificationTransformer());

        return $response;
    }

    public function show($notification_id)
    {
        $userId = $user = app('Dingo\Api\Auth\Auth')->user()->id;

        $notification = $this->notificationRepository->readNotification($userId, $notification_id);

        return $notification;
    }

    public function countUnreadNotifications()
    {
       // $user_id = Auth::user()->id;
       // $count = $this->notificationRepository->countUnreadNotifications($user_id);
        //dd($count);
    }

    public function storeNotification(Request $request){
        $notification = $this->notificationRepository->storeNotification($request->item_type, $request->item_id, $request->user_id);
        $response = $this->response->item($notification, new NotificationTransformer());
        return $response;
    }

    public function readNotification($userId, $notificationId)
    {
        $notification = $this->notificationRepository->readNotification($userId, $notificationId);

        $response = $this->response->item($notification, new NotificationTransformer($userId));

        return $response;
    }
}