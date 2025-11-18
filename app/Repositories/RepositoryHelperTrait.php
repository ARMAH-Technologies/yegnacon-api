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
use App\Entities\ContractorAndConsultant;
use App\Entities\Employee;
use App\Entities\Professional;
use App\Entities\ProformaRequest;
use App\Entities\ProjectOwner;
use App\Entities\Supplier;
use App\Entities\Users\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Entities\ProformaUserGroups;

trait RepositoryHelperTrait
{
    public function sendEmail($email, $data, $template, $subject)
    {
        Mail::queue($template, $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }

    protected function getUserProfileType($user_id)
    {
        return User::find($user_id)->profile_type;
    }

    public function getUserProfile($user_id)
    {
        $profile_type = $this->getUserProfileType($user_id);
        $profile = null;

        if($profile_type === 'Contractor'){
            $profile = Contractor::where('user_id', $user_id)->first();
        }
        if($profile_type === 'Consultant'){
            $profile = Consultant::where('user_id', $user_id)->first();
        }
        if($profile_type === 'ContractorAndConsultant'){
            $profile = ContractorAndConsultant::where('user_id', $user_id)->first();
        }
        else if($profile_type === 'Supplier'){
            $profile = Supplier::where('user_id', $user_id)->first();
        }
        else if($profile_type === 'Professional'){
            $profile = Professional::where('user_id', $user_id)->first();
        }
        else if($profile_type === 'ProjectOwner'){
            $profile = ProjectOwner::where('user_id', $user_id)->first();
        }else if($profile_type === 'Employee'){
            $profile = Employee::where('user_id', $user_id)->first();
        }

        return $profile;
    }

    protected function getUserCategoryIds($userId, $type){

        $categories = $this->getUserCategories($userId, $type);

        $categoryIds = collect();
        foreach($categories as $category){
            $categoryIds->push($category->id);
        }

        return $categoryIds;
    }

    protected function getUserGroupIds($userId)
    {
        $groups = ProformaUserGroups::where('user_id', $userId)->get();

        $groupIds = collect();

        foreach ($groups as $group) {
            $groupIds->push($group->group_id);
        }
        
        return $groupIds;
    }

    protected function getUserGroups($userId) 
    {
        $profile = $this->getUserProfile($userId);
        $groups = collect();
        $groups = $profile->proformaGroups()->get();

        return $groups;
    }

    protected function getProformaRequestType($proformaRequestId){
        $type = ProformaRequest::find($proformaRequestId)->type;

        return $type;
    }

    public function getUserCategories($userId, $type)
    {
        $profile = $this->getUserProfile($userId);

        $categories = collect();
        if ($type === 'Proforma') {
            $categories = $profile->proformaCategories()->get();
        } else if ($type === 'Tender') {
            $categories = $profile->tenderCategories()->get();
        }

        return $categories;
    }

}