<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/14/2016
 * Time: 11:36 AM
 */

namespace App\Repositories;


use App\Entities\Notification;
use App\Entities\Users\User;

class NotificationRepository
{
    use NotificationTrait;

    public function getAllNotifications($n)
    {
        $notifications = Notification::latest()->get();

        return $notifications;
    }

    public function storeNotification($item_type, $item_id, $user_id)
    {
        $notification = $this->saveNotification($item_type, $item_id, $user_id);
        return $notification;
    }

    public function getUserNotifications($id, $n)
    {
        return User::find($id)->notifications()->where('status', 'unread')->latest()->get();
    }

    public function readNotification($user_id, $notification_id)
    {
        $notification = Notification::find($notification_id);

        $notificationIds = $this->getUserAllNotificationIdsHaveSameItemId($user_id, $notification->item_id);

        foreach($notificationIds as $notificationId) {
            $this->changeNotificationStatus($user_id, $notificationId, 'read');
        }

        return Notification::find($notification_id);
    }

    public function countUnreadNotifications($user_id)
    {
        return User::find($user_id)->notifications()->wherePivot('status', 'unread')->count();
    }

    public function getUserAllNotificationIdsHaveSameItemId($userId, $itemId)
    {
        $notifications = User::find($userId)->notifications()
            ->where('item_id', $itemId)
            ->where('status', 'unread')
            ->get();

        $notificationIds = collect();
        foreach($notifications as $notification){
            $notificationIds->push($notification->id);
        }

        return $notificationIds;
    }
}