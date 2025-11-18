<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 4/27/2016
 * Time: 11:20 AM
 */

namespace App\Transformers;


use App\Entities\Consultant;
use App\Entities\Contractor;
use App\Entities\ContractorAndConsultant;
use App\Entities\ProjectOwner;
use App\Entities\Supplier;
use App\Entities\Users\User;
use App\Entities\UserSubscription;

trait TransformerHelperTrait
{
    protected function getItemLogo($item, $item_type)
    {
        $logo = null;
        if ($item_type === 'User' && $item->user->file) {
            $file = $item->user->file;
            $logo = $file ? $file->file_path . '/' . $file->original : '';
        } else if ($item_type === 'Company' && $item->file) {
            $file = $item->file;
            $logo = $file ? $file->file_path . '/' . $file->original : '';
        } else if ($item_type === 'News' && $item->files->count() != 0) {
            $file = $item->files->first();
            $logo = $file ? $file->file_path . '/' . $file->original : '';
        }

        return $logo;
    }

    protected function getProformaRequesterUser($proformaRequest)
    {
        $user = $this->getProfile($proformaRequest->requester_type, $proformaRequest->requester_id)->user;

        return $user;
    }

    protected function getProformaResponderUser($proformaResponse)
    {
        $user = $this->getProfile($proformaResponse->responder_type, $proformaResponse->responder_id)->user;

        return $user;
    }

    protected function getUser($userId)
    {
        return User::find($userId);
    }

    protected function getProfile($profile_type, $profile_id)
    {
        $profile = null;

        if ($profile_type === 'Contractor') {
            $profile = Contractor::find($profile_id);
        }
        if ($profile_type === 'Consultant') {
            $profile = Consultant::find($profile_id);
        }
        if ($profile_type === 'ContractorAndConsultant') {
            $profile = ContractorAndConsultant::find($profile_id);
        } else if ($profile_type === 'Supplier') {
            $profile = Supplier::find($profile_id);
        } else if ($profile_type === 'ProjectOwner') {
            $profile = ProjectOwner::find($profile_id);
        }

        return $profile;
    }

    protected function countNewsComments($news)
    {
        $totalComments = $news->comments->count();

        return $totalComments;
    }

    protected function countProformaRequestItems($proformaRequest)
    {
        $count = $proformaRequest->proformaRequestItems->count();

        return $count;
    }

    protected function countProformaRequestResponses($proformaRequest)
    {
        $count = $proformaRequest->proformaResponses->count();

        return $count;
    }

    protected function countProformaResponseItems($proformaResponse)
    {
        $count = $proformaResponse->proformaResponseItems->count();

        return $count;
    }

    protected function getCurrentSubscription($user_id)
    {
        return UserSubscription::where(["user_id" => $user_id])
            /*    ->where('expiration_date','>=',\Carbon\Carbon::now())*/
            ->latest()
            ->first();
    }
}