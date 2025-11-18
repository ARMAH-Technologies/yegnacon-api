<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/13/2016
 * Time: 5:52 PM
 */

namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Consultant;
use App\Entities\Contractor;
use App\Entities\ProformaRequest;
use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use App\Entities\Notification;
use App\Entities\ProformaResponse;
use App\Entities\ProformaResponseProjectCost;
use App\Entities\ProjectOwner;
use App\Entities\Users\User;
use Webpatser\Uuid\Uuid;

trait NotificationTrait
{
    public function saveNotification($type, $item_id, $user_id)
    {
        if ($type == "ProjectCostRequest") {
            return $this->saveProjectCostRequest($type, $item_id, $user_id);

        } else if ($type == "ProformaRequestItem") {
            return $this->saveProductItemRequest($type, $item_id, $user_id);
        } else if ($type == "ProjectCostResponse") {
            return $this->saveProjectCostResponse($type, $item_id, $user_id);

        } else if ($type == "ProformaResponseItem") {
            return $this->saveProductItemResponse($type, $item_id, $user_id);
        }
    }

    private function saveProjectCostRequest($type, $item_id, $user_id)
    {
        $projectProforma = ProformaRequestProjectCost::find($item_id);
        $to_ids = $this->getNotificationReceivers($projectProforma->type, $projectProforma->level);
        $notification = $this->storeN($type, $projectProforma->proformaRequest->id, $user_id, $to_ids, $projectProforma->title);
        return $notification;
    }

    private function saveProjectCostResponse($type, $item_id, $user_id)
    {
        $projectProformaResponse = ProformaResponseProjectCost::find($item_id);
        $proformaRequest = $projectProformaResponse->proformaResponse->proformaRequest;
        $to_ids = [$this->getUser($proformaRequest)->id];
        $notification = $this->storeN($type, $proformaRequest->id, $user_id, $to_ids, $proformaRequest->proformaRequestProjectCost->title);
        return $notification;
    }

    private function saveProductItemRequest($type, $item_id, $user_id)
    {
        $proformaRequest = ProformaRequest::find($item_id);
        $proformaRequestItems = $proformaRequest->proformaRequestItems;

        $notification = null;
        foreach ($proformaRequestItems as $proformaRequestItem) {

            $to_ids = $this->getProformaRequestItemSuppliers($proformaRequestItem);

            $notification = $this->storeN($type, $proformaRequest->id, $user_id, $to_ids, $proformaRequestItem->item_name);
        }

        return $notification;
    }

    private function saveProductItemResponse($type, $item_id, $user_id)
    {
        $proformaResponse = ProformaResponse::find($item_id);

        $to_ids = [$this->getUser($proformaResponse->proformaRequest)->id];

        $notification = $this->storeN($type, $proformaResponse->proformaRequest->id, $user_id, $to_ids,
            $proformaResponse->proformaRequest->proforma_request_id);

        return $notification;
    }

    public function getProformaRequestSuppliers($proformaRequestId)
    {
        $proformaRequestCategoryIds = $this->getProformaRequestCategoryIds($proformaRequestId);

        $toUsers = User::whereHas('supplier.proformaCategories', (function ($query) use ($proformaRequestCategoryIds) {
            $query->whereIn('category_id', $proformaRequestCategoryIds);
        }))->get();

        $to_ids = collect();
        foreach ($toUsers as $toUser) {
            $to_ids->push($toUser->id);
        }

        return $to_ids;
    }

    public function getProformaRequestItemSuppliers($proformaRequestItem)
    {
        $toUsers = User::whereHas('supplier.proformaCategories', (function ($query) use ($proformaRequestItem) {
            $query->where('category_id', $proformaRequestItem->category_id);
        }))->get();

        $to_ids = collect();
        foreach ($toUsers as $toUser) {
            $to_ids->push($toUser->id);
        }

        return $to_ids;
    }

    private function getUser($proformaRequest)
    {
        if ($proformaRequest->requester_type == "Consultant") {
            return Consultant::find($proformaRequest->requester_id)->user;
        } else if ($proformaRequest->requester_type == "Contractor") {
            return Contractor::find($proformaRequest->requester_id)->user;
        } else if ($proformaRequest->requester_type == "ProjectOwner") {
            return ProjectOwner::find($proformaRequest->requester_id)->user;
        }
    }

    private function storeN($type, $item_id, $from_id, $to_ids, $item_name = null)
    {
        $title = $this->generate_notification_title($from_id, $type, $item_name);

        $notification = new Notification();
        $notification->id = $id = Uuid::generate(4);
        $notification->title = $title;
        $notification->type = $type;
        $notification->item_id = $item_id;
        $notification->save();
        $not = Notification::find($id);

        foreach ($to_ids as $to_id) {
            User::find($to_id)->notifications()->attach($not->id, ['status' => 'unread', 'from_id' => $from_id]);
        }

        return $not;
    }

    public function generate_notification_title($from_id, $type, $item_name)
    {
        $user = User::find($from_id);

        if ($type === 'ProjectCostRequest') {
            return $user->name . ' posted ' . $item_name . ' project.';
        } else if ($type === 'ProjectCostResponse') {
            return $user->name . ' responded to ' . $item_name;
        } else if ($type == 'ProformaRequestItem') {
            return $user->name . ' wants ' . $item_name;
        } else if ($type == 'ProformaResponseItem') {
            return $user->name . ' responded to ' . ' proforma request Id: ' . $item_name;
        }
    }

    private function getNotificationReceivers($userType, $userLevel)
    {
        $to_ids = [];
        $toUsers = User::get();
        foreach ($toUsers as $user) {
            if ($user->profile_type == "Consultant") {
                if ($user->consultant) {
                    if ($user->consultant->type == $userType && $user->consultant->level == $userLevel) {
                        $to_ids[] = $user->id;
                    }
                }
            } else if ($user->profile_type == "Contractor") {
                if ($user->contractor) {
                    if ($user->contractor->type == $userType && $user->contractor->level == $userLevel) {
                        $to_ids[] = $user->id;
                    }
                }
            }
        }
        return $to_ids;
    }

    public function changeNotificationStatus($userId, $notificationId, $status)
    {
        $notification = User::find($userId)->notifications()->updateExistingPivot($notificationId, ['status' => $status]);

        return $notification;
    }

    public function getProformaRequestCategoryIds($proformaRequestId)
    {
        $categories = Category::whereHas('proformaRequestItems', (function ($query) use ($proformaRequestId) {
            $query->where('proforma_request_id', $proformaRequestId);
        }))
            ->get();

        $categoryIds = collect();
        foreach ($categories as $category) {
            $categoryIds->push($category->id);
        }

        return $categoryIds;
    }

}