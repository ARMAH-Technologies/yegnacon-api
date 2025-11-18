<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/13/2016
 * Time: 5:52 PM
 */

namespace App\Repositories;

use App\Entities\Address;
use App\Entities\Category;
use App\Entities\Company;
use App\Entities\Contractor;
use App\Entities\Education;
use App\Entities\Experience;
use App\Entities\Professional;
use App\Entities\ProformaItem;
use App\Entities\ProformaRequest;
use App\Entities\ProformaRequestConsultantCost;
use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use App\Entities\ProformaResponse;
use App\Entities\ProformaResponseConsultantCost;
use App\Entities\ProformaResponseItem;
use App\Entities\ProformaResponseProjectCost;
use App\Entities\ProformaGroups;
use App\Entities\ProformaUserGroups;
use App\Entities\Project;
use App\Entities\ProjectOwner;
use App\Entities\Skill;
use App\Entities\Supplier;
use App\Entities\Users\User;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

trait ProformaTrait
{
    protected function saveProformaRequest($input,$requesterId, $requesterType, $status)
    {
        $proformaRequest = new ProformaRequest();
        $proformaRequest->id = $id = Uuid::generate(4);
        $proformaRequest->type = $input['type'];
        $proformaRequest->proforma_request_id = $this->getLastProformaId($requesterId, 'ProformaRequest') + 1;
        $proformaRequest->requester_id = $requesterId;
        $proformaRequest->requester_type = $requesterType;
        $proformaRequest->status = $status;
        $proformaRequest->save();

        return ProformaRequest::find($id);
    }

    protected function saveGroup($input, $created_by)
    {
        $group = new ProformaGroups();
        $group->id = $id = Uuid::generate(4);
        $group->type = isset($input['type']) ? $input['type'] : '';
        $group->status = isset($input['status']) ? $input['status'] : '';
        $group->created_by = $created_by;
        $group->name = $input['name'];
        $group->save();

        return ProformaGroups::find($id);
    }

    protected function saveUserToGroup($groupId, $userId)
    {
        $exists = ProformaUserGroups::where('group_id', $groupId)->where('user_id', $userId)->get();

        if(count($exists)) {
            $userGroup = ProformaUserGroups::find($groupId);
            return $userGroup;
        } else {
            $userGroup = new ProformaUserGroups();
            $userGroup->id = $id = Uuid::generate(4);
            $userGroup->group_id = $groupId;
            $userGroup->user_id = $userId;
            $userGroup->save();
            return ProformaUserGroups::find($id);
        } 
    }

    protected function updateGroup($input, $groupId) 
    {
        $group = ProformaGroups::findOrFail($groupId);
        $group->type = isset($input['type']) ? $input['type'] : '';
        $group->status = isset($input['status']) ? $input['status'] : '';
        $group->name = $input['name'];
        $group->save();

        return ProformaGroups::find($groupId);
    }


    protected function saveProformaRequestItem($input, $proformaRequestId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaRequestItem = ProformaRequestItem::find($id);
            $proformaRequestItem->item_name = $input['item_name'];
            $proformaRequestItem->quantity = isset($input['quantity']) ? $input['quantity'] : $proformaRequestItem->quantity;
            $proformaRequestItem->unit = isset($input['unit']) ? $input['unit'] : $proformaRequestItem->unit;
            $proformaRequestItem->description = isset($input['description']) ? $input['description'] : $proformaRequestItem->description;
            $proformaRequestItem->save();
        } else {
            $proformaRequestItem = new ProformaRequestItem();
            $proformaRequestItem->id = $id = Uuid::generate(4);
            $proformaRequestItem->proforma_request_id = $proformaRequestId;
            $proformaRequestItem->category_id = $input['category_id'];
            $proformaRequestItem->item_name = $input['item_name'];
            $proformaRequestItem->quantity = isset($input['quantity']) ? $input['quantity'] : null;
            $proformaRequestItem->unit = isset($input['unit']) ? $input['unit'] : null;
            $proformaRequestItem->description = isset($input['description']) ? $input['description'] : null;
            $proformaRequestItem->filter_id = isset($input['filter_id']) ? $input['filter_id'] : null;
            $proformaRequestItem->filter_type = isset($input['filter_type']) ? $input['filter_type'] : null;
            $proformaRequestItem->save();
        }

        return ProformaRequestItem::find($id);
    }

    protected function saveProformaRequestProjectCost($input, $proformaRequestId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaRequestProjectCost = ProformaRequestProjectCost::find($id);
            $proformaRequestProjectCost->title = $input['title'];
            $proformaRequestProjectCost->type = $input['type'];
            $proformaRequestProjectCost->level = $input['level'];
            $proformaRequestProjectCost->description = isset($input['description']) ? $input['description'] : $proformaRequestProjectCost->description;
            $proformaRequestProjectCost->save();
        } else {
            $proformaRequestProjectCost = new ProformaRequestProjectCost();
            $proformaRequestProjectCost->id = $id = Uuid::generate(4);
            $proformaRequestProjectCost->proforma_request_id = $proformaRequestId;
            $proformaRequestProjectCost->title = $input['title'];
            $proformaRequestProjectCost->description = isset($input['description']) ? $input['description'] : null;
            $proformaRequestProjectCost->type = $input['type'];
            $proformaRequestProjectCost->level = $input['level'];
            $proformaRequestProjectCost->save();
        }

        return ProformaRequestProjectCost::find($id);
    }

    protected function saveProformaRequestConsultantCost($input, $proformaRequestId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaRequestConsultantCost = ProformaRequestConsultantCost::find($id);
            $proformaRequestConsultantCost->title = $input['title'];
            $proformaRequestConsultantCost->description = isset($input['description']) ? $input['description'] : $proformaRequestConsultantCost->description;
            $proformaRequestConsultantCost->type = $input['type'];
            $proformaRequestConsultantCost->level = $input['level'];
            $proformaRequestConsultantCost->save();
        } else {
            $proformaRequestConsultantCost = new ProformaRequestConsultantCost();
            $proformaRequestConsultantCost->id = $id = Uuid::generate(4);
            $proformaRequestConsultantCost->proforma_request_id = $proformaRequestId;
            $proformaRequestConsultantCost->title = $input['title'];
            $proformaRequestConsultantCost->description = isset($input['description']) ? $input['description'] : null;
            $proformaRequestConsultantCost->type = $input['type'];
            $proformaRequestConsultantCost->level = $input['level'];
            $proformaRequestConsultantCost->save();
        }

        return ProformaRequestConsultantCost::find($id);
    }

    protected function saveProformaResponse($input,$proformaRequestId, $responderId, $responderType)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaResponse = ProformaResponse::find($id);
            $proformaResponse->validity_date = isset($input['validity_date']) ? $input['validity_date'] : $proformaResponse->validity_date;
            $proformaResponse->save();
        } else {
            $proformaResponse = new ProformaResponse();
            $proformaResponse->id = $id = Uuid::generate(4);
            $proformaResponse->proforma_invoice_id = $this->getLastProformaId($responderId, 'ProformaResponse') + 1;
            $proformaResponse->proforma_request_id = $proformaRequestId;
            $proformaResponse->responder_id = $responderId;
            $proformaResponse->responder_type = $responderType;
            $proformaResponse->validity_date = isset($input['validity_date']) ? $input['validity_date'] : null;
            $proformaResponse->save();
        }

        return ProformaResponse::find($id);
    }

    protected function saveProformaResponseItem($input, $proformaResponseId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaResponseItem = ProformaResponseItem::find($id);
            $proformaResponseItem->quantity = $input['quantity'];
            $proformaResponseItem->price = isset($input['price']) ? $input['price'] : $proformaResponseItem->price;
            $proformaResponseItem->unit = isset($input['unit']) ? $input['unit'] : $proformaResponseItem->unit;
            $proformaResponseItem->delivery_type = isset($input['delivery_type']) ? $input['delivery_type'] : $proformaResponseItem->delivery_type;
            $proformaResponseItem->delivery_date = isset($input['delivery_date']) ? $input['delivery_date'] : $proformaResponseItem->delivery_date;
            $proformaResponseItem->description = isset($input['description']) ? $input['description'] : $proformaResponseItem->description;
            $proformaResponseItem->save();
        } else {
            $proformaResponseItem = new ProformaResponseItem();
            $proformaResponseItem->id = $id = Uuid::generate(4);
            $proformaResponseItem->proforma_response_id = $proformaResponseId;
            $proformaResponseItem->proforma_request_item_id = $input['proforma_request_item_id'];
            $proformaResponseItem->quantity = $input['quantity'];
            $proformaResponseItem->price = isset($input['price']) ? $input['price'] : null;
            $proformaResponseItem->unit = isset($input['unit']) ? $input['unit'] : null;
            $proformaResponseItem->delivery_type = isset($input['delivery_type']) ? $input['delivery_type'] : null;
            $proformaResponseItem->delivery_date = isset($input['delivery_date']) ? $input['delivery_date'] : null;
            $proformaResponseItem->description = isset($input['description']) ? $input['description'] : null;
            $proformaResponseItem->save();
        }

        return ProformaResponseItem::find($id);
    }

    protected function saveProformaResponseProjectCost($input, $proformaResponseId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaResponseProjectCost = ProformaResponseProjectCost::find($id);
            $proformaResponseProjectCost->title = $input['title'];
            $proformaResponseProjectCost->description = isset($input['description']) ? $input['description'] : $proformaResponseProjectCost->description;
            $proformaResponseProjectCost->save();
        } else {
            $proformaResponseProjectCost = new ProformaResponseProjectCost();
            $proformaResponseProjectCost->id = $id = Uuid::generate(4);
            $proformaResponseProjectCost->proforma_response_id = $proformaResponseId;
            $proformaResponseProjectCost->title = $input['title'];
            $proformaResponseProjectCost->description = isset($input['description']) ? $input['description'] : null;
            $proformaResponseProjectCost->save();
        }

        return ProformaResponseProjectCost::find($id);
    }

    protected function saveProformaResponseConsultantCost($input, $proformaResponseId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $proformaResponseConsultantCost = ProformaResponseConsultantCost::find($id);
            $proformaResponseConsultantCost->title = $input['title'];
            $proformaResponseConsultantCost->description = isset($input['description']) ? $input['description'] : $proformaResponseConsultantCost->description;
            $proformaResponseConsultantCost->save();
        } else {
            $proformaResponseConsultantCost = new ProformaResponseConsultantCost();
            $proformaResponseConsultantCost->id = $id = Uuid::generate(4);
            $proformaResponseConsultantCost->proforma_response_id = $proformaResponseId;
            $proformaResponseConsultantCost->title = $input['title'];
            $proformaResponseConsultantCost->description = isset($input['description']) ? $input['description'] : null;
            $proformaResponseConsultantCost->save();
        }

        return ProformaResponseConsultantCost::find($id);
    }

    private function getLastProformaId($profileId, $type)
    {
        $id = 0;
        if($type === 'ProformaRequest'){
            $proformaRequest =  ProformaRequest::where('requester_id', $profileId)
                ->latest()
                ->first();
            if($proformaRequest){
                $id = $proformaRequest->proforma_request_id;
            }
        }
        else if($type === 'ProformaRequest'){
            $proformaResponse = ProformaResponse::where('responder_id', $profileId)
                ->latest()
                ->first();

            if($proformaResponse){
                $id = $proformaResponse->proforma_invoice_id;
            }
        }

        return $id;
    }


}