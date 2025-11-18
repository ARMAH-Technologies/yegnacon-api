<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\ProformaRequest;
use App\Entities\ProformaRequestItem;
use App\Entities\ProformaRequestProjectCost;
use App\Entities\ProformaResponse;
use App\Entities\ProformaUserGroups;
use App\Entities\ProformaGroups;

class ProformaRepository
{
    use RepositoryHelperTrait;
    use ProformaTrait;
    use StatusTrait;
    use NotificationTrait;

    public function getProformasCount()
    {
        $count = ProformaRequest::count();
        $responseCount = ProformaRequest::has('proformaResponses')->count();
        $response = array("proforma" => array());
        $response["proforma"]["itemsCount"] = $count;
        $response["proforma"]["itemsWithResponseCount"] = $responseCount;
        $response["proforma"]["itemsPendingResponseCount"] = $count - $responseCount;
        return $response;
    }

    public function getAllProformaRequests($n)
    {
        return ProformaRequest::latest()->paginate($n);
    }

    public function getUserProductProformaRequests($userId, $n)
    {
        $profileType = $this->getUserProfileType($userId);

        $proformaRequests = null;
        if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
            || $profileType === 'Consultant'
        ) {
            $proformaRequests = $this->getProductRequesterProformaRequests($userId, $n);
        } else if ($profileType === 'Supplier') {
            $proformaRequests = $this->getProductReplierProformaRequests($userId, $n);
        }

        return $proformaRequests->sortByDesc('created_at');
    }

    public function getUserProjectProformaRequests($userId, $n)
    {
        $profileType = $this->getUserProfileType($userId);

        $proformaRequests = null;
        if ($profileType === 'ProjectOwner') {
            $proformaRequests = $this->getProjectRequesterProformaRequests($userId, $n);
        } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
            || $profileType === 'Consultant'
        ) {
            $proformaRequests = $this->getProjectReplierProformaRequests($userId, $n);
        }

        return $proformaRequests;
    }

    public function getProjectFromCompanyProformaRequests($userId, $n)
    {
        $profileType = $this->getUserProfileType($userId);

        $proformaRequests = null;
        if ($profileType === 'ProjectOwner') {
            $proformaRequests = $this->getProjectRequesterProformaRequests($userId, $n);
        } else if ($profileType === 'Contractor' || $profileType === 'ContractorAndConsultant'
            || $profileType === 'Consultant'
        ) {
            $proformaRequests = $this->getProjectReplierProformaRequests($userId, $n);
        }

        return $proformaRequests;
    }

    private function getProductRequesterProformaRequests($userId, $n)
    {
        $profileId = $this->getUserProfile($userId)->id;

        $proformaRequests = ProformaRequest::where('requester_id', $profileId)
            ->where('type', 'Product')
            ->latest()
            ->get();
        return $proformaRequests;
    }

    public function getProjectRequesterProformaRequests($userId, $n)
    {
        $profileId = $this->getUserProfile($userId)->id;

        $proformaRequests = ProformaRequest::where('requester_id', $profileId)
            ->where('type', 'ProjectCost')
            ->latest()
            ->paginate($n);

        return $proformaRequests;
    }

    private function getProductReplierProformaRequests($userId, $n)
    {
        $categoryIds = $this->getUserCategoryIds($userId, 'Proforma');
        $profileId = $this->getUserProfile($userId)->id;
        $groupIds = $this->getUserGroupIds($profileId);

        $categoryResults = ProformaRequest::whereHas('proformaRequestItems', (function ($query) use ($categoryIds) {
            $query->where('filter_type', 'all')->whereIn('category_id', $categoryIds);
        }))->latest()->get();

        $groupResults = ProformaRequest::whereHas('proformaRequestItems', (function ($query) use ($groupIds) {
            $query->where('filter_type', 'group')->whereIn('filter_id', $groupIds);
        }))->get();

        $userResult = ProformaRequest::whereHas('proformaRequestItems', (function ($query) use ($groupIds, $userId) {
            $query->where('filter_type', 'user')->where('filter_id', $userId);
        }))->latest()->get();

        $result = $categoryResults->merge($groupResults)->merge($userResult);
        
        return $result;
    }

    public function getProjectReplierProformaRequests($userId, $n)
    {
        $profile = $this->getUserProfile($userId);

        $proformaRequests = ProformaRequest::whereHas('proformaRequestProjectCost', (function ($query) use ($profile) {
            $query->where('type', $profile->type);
            $query->where('level', $profile->level);
        }))
            ->where('requester_id', '<>', $profile->id)
            ->latest()
            ->paginate($n);

        return $proformaRequests;
    }

    public function getProformaResponses($proformaId, $per_page)
    {
        $proformaResponses = ProformaResponse::where('proforma_request_id', $proformaId)
            ->paginate($per_page);

        return $proformaResponses;
    }

    public function getProformaRequestItems($proformaId, $per_page)
    {
        $proformaResponses = ProformaRequestItem::where('proforma_request_id', $proformaId)
            ->paginate($per_page);

        return $proformaResponses;
    }

    public function getProformaRequestDetail($id)
    {
        return ProformaRequest::findOrFail($id);
    }

    public function getProformaResponseDetail($id)
    {
        return ProformaResponse::findOrFail($id);
    }


    public function getGroupDetails($id)
    {
        $group = ProformaGroups::findOrFail($id);
        return $group;
    }

    public function storeProformaRequest($input, $userId)
    {
        $proformaRequest = null;

        $type = $input->proformaRequest['type'];

        if ($type === 'Product') {
            $proformaRequest = $this->storeProformaRequestProduct($input, $userId);
        } else if ($type === 'ProjectCost') {
            $proformaRequest = $this->storeProformaRequestProjectCost($input, $userId);
        } else if ($type === 'ConsultantCost') {
            $proformaRequest = $this->storeProformaRequestConsultantCost($input, $userId);
        }

        return $proformaRequest;
    }

    public function storeProformaGroup($input, $userId)
    {
        $profile_id = $this->getUserProfile($userId)->id;
        $storeGroup = $this->saveGroup($input, $profile_id);

        return $storeGroup;
    }

    public function addUserProformaGroup($input, $group_id)
    {
        $group = ProformaGroups::findOrFail($group_id);

        foreach ($input->users as $userId) {
            $profile_id = $this->getUserProfile($userId)->id;
            $this->saveUserToGroup($group_id, $profile_id);
        }

        return $group;

    }

    public function updateProformaGroup($input, $groupId) 
    {
        $updateGroup = $this->updateGroup($input->group, $groupId);
        $addUsers = $this->addUserProformaGroup($input, $groupId);

        return $updateGroup;
    }


    public function deleteGroup($id)
    {
        $group = ProformaGroups::findOrFail($id);
        $group->delete();

        return $group;
    }

    public function storeProformaRequestProduct($input, $userId)
    {
        $profileType = $this->getUserProfileType($userId);
        $profileId = $this->getUserProfile($userId)->id;
        $groupIds = $this->getUserGroupIds($profileId);

        $proformaRequest = $this->saveProformaRequest($input->proformaRequest, $profileId, $profileType, $this->proformaRequestStatus);

        foreach ($input->proformaItems as $proformaItem) {
            $this->saveProformaRequestItem($proformaItem, $proformaRequest->id);
        }

 /*       if($proformaRequest->filter_type === "group" && $proformaRequest->filter_type === "user") {
            if($groupIds->contains($proformaRequest->filter_id)) {
                $this->saveNotification("ProformaRequestItem", $proformaRequest->id, $userId);
            } else {
                return $proformaRequest;
            }
        } */

        if($proformaRequest->filter_type === "group") {
            if($groupIds->contains($proformaRequest->filter_id)) {
                $this->saveNotification("ProformaRequestItem", $proformaRequest->id, $userId);
            }
        }

        if($groupIds->contains($proformaRequest->filter_id) || $proformaRequest->filter_id === $userId || $proformaRequest->filter_type === "all") {
            $this->saveNotification("ProformaRequestItem", $proformaRequest->id, $userId);
            return $proformaRequest;
        } else {
            return $proformaRequest;
        }
    }

    public function storeProformaRequestProjectCost($input, $userId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $proformaRequest = $this->saveProformaRequest($input->proformaRequest, $profileId, $profileType, $this->proformaRequestStatus);

        $proformaRequestProjectCost = $this->saveProformaRequestProjectCost($input->proformaRequestProjectCost, $proformaRequest->id);

        $this->saveNotification("ProjectCostRequest", $proformaRequestProjectCost->id, $userId);

        return $proformaRequest;
    }

    public function storeProformaRequestConsultantCost($input, $userId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $proformaRequest = $this->saveProformaRequest($input->proformaRequest, $profileId, $profileType, $this->proformaRequestStatus);

        $this->saveProformaRequestConsultantCost($input->proformaRequestConsultantCost, $proformaRequest->id);

        return $proformaRequest;
    }

    public function storeProformaResponse($input, $userId, $proformaRequestId)
    {
        $proformaRequest = null;

        $type = $this->getProformaRequestType($proformaRequestId);

        if ($type === 'Product') {
            $proformaRequest = $this->storeProformaResponseProduct($input, $userId, $proformaRequestId);
        } else if ($type === 'ProjectCost') {
            $proformaRequest = $this->storeProformaResponseProjectCost($input, $userId, $proformaRequestId);
        } else if ($type === 'ConsultantCost') {
            $proformaRequest = $this->storeProformaResponseConsultantCost($input, $userId, $proformaRequestId);
        }

        return $proformaRequest;
    }

    public function storeProformaResponseProduct($input, $userId, $proformaRequestId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $proformaResponse = $this->saveProformaResponse($input->proformaResponse, $proformaRequestId, $profileId, $profileType);

        foreach ($input->proformaResponseItems as $proformaResponseItem) {
            $this->saveProformaResponseItem($proformaResponseItem, $proformaResponse->id);
        }


        $this->saveNotification("ProformaResponseItem", $proformaResponse->id, $userId);

        return $proformaResponse;
    }

    public function storeProformaResponseProjectCost($input, $userId, $proformaRequestId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $proformaResponse = $this->saveProformaResponse($input->proformaResponse, $proformaRequestId, $profileId, $profileType);

        $proformaResponseProjectCost = $this->saveProformaResponseProjectCost($input->proformaResponseProjectCost, $proformaResponse->id);

        $this->saveNotification("ProjectCostResponse", $proformaResponseProjectCost->id, $userId);

        return $proformaResponse;
    }

    public function storeProformaResponseConsultantCost($input, $userId, $proformaRequestId)
    {
        $profileId = $this->getUserProfile($userId)->id;
        $profileType = $this->getUserProfileType($userId);

        $proformaResponse = $this->saveProformaResponse($input->proformaResponse, $proformaRequestId, $profileId, $profileType);

        $this->saveProformaResponseConsultantCost($input->proformaResponseConsultantCost, $proformaResponse->id);

        return $proformaResponse;
    }

}