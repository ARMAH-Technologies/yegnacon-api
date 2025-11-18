<?php

namespace App\Transformers;

use App\Entities\Notification;
use App\Entities\Users\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    use TransformerHelperTrait;

    private $user = null;
    /**
     * NotificationTransformer constructor.
     */
    public function __construct($userId = null)
    {
        $this->user = User::find($userId);
    }

    public function transform(Notification $notification)
    {
        if($this->user) {
           $user = $this->user;
        }else{
            $user = $this->getUser($notification->pivot->from_id);
        }

        $notf = [
            'id' => $notification->id,
            'item_id' => $notification->item_id,
            'title' => $notification->title,
            'type' => $notification->type,
            'created_at' => Carbon::parse($notification->created_at)->toFormattedDateString(),
            'status' => $notification->pivot->status,
            'user_name' => $user->name
        ];

        if ($user->file){
            $logo = $user->file ? $user->file->file_path . '/' .  $user->file->thumbnail : '';
            $notf["user_logo"] = $logo;
        }


        return $notf;
    }



}