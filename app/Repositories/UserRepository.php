<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 2/25/2016
 * Time: 8:35 PM
 */

namespace App\Repositories;

use App\Entities\ProformaUserGroups;
use App\Entities\Users\User;
use App\Entities\UserSubscription;
use App\Entities\UserSubscriptionPackage;

class UserRepository
{
    use RepositoryHelperTrait;
    use UserTrait;

    public function getAllUsers($request, $isDropDown, $n)
    {
        if ($isDropDown) {
            $users = User::filterUser($request)
                ->get();
        } else {
            $users = User::searchUser($request)->latest()
                ->filterUser($request)
                ->paginate($n);
        }

        return $users;
    }

    public function getCurrentUser()
    {
        $user = app('Dingo\Api\Auth\Auth')->user();

        return User::find($user->id);
    }

    public function getUserDetail($user_id)
    {
        return User::find($user_id);
    }

    public function changeStatus($id, $status)
    {
        $user = User::find($id);
        //User Trait :: subscribe
        $user->status = $status;
        $user->save();
        return $user;
    }

    public function storeUser($input)
    {
        if($input->profile_type == "Employee"){
            $user = $this->saveUser($input);
        }else{
            $user = $this->saveUser($input->user);
        }

        $this->saveProfile($input, $user->id);

        return $user;
    }

    public function update($input, $userId)
    {
        $profileType = $this->getUserProfileType($userId);


        if ($profileType === 'Contractor') {
            $this->updateContractor($input, $userId);
        } else if ($profileType === 'Consultant') {
            $this->updateConsultant($input, $userId);
        } else if ($profileType === 'ContractorAndConsultant') {
            $this->updateContractorAndConsultant($input, $userId);
        } else if ($profileType === 'Supplier') {
            $this->updateSupplier($input, $userId);
        } else if ($profileType === 'Professional') {
            $this->updateProfessional($input, $userId);
        }else if ($profileType === 'Employee') {
            $this->updateEmployee($input, $userId);
        }else if ($profileType === 'ProjectOwner') {
            $this->updateProjectOwner($input, $userId);
        }

        return $this->getUserDetail($userId);
    }

    public function changePassword($user_id, $oldPassword, $newPassword)
    {
        if ($this->checkOldPassword($user_id, $oldPassword)) {
            $this->changePasswordT($user_id, $newPassword);
            return 'Password Change Successfully';
        } else {
            return 'Old Password InCorrect';
        }
    }

    public function resetPassword($user_id, $newPassword)
    {
        $this->changePasswordT($user_id, $newPassword);
        return 'Password Change Successfully';
    }

    private function updateContractor($input, $userId)
    {
        //dd($input->all());
        $profileType = $this->getUserProfileType($userId);

        $contractor = $this->saveContractor($input->contractor, $userId);

        $this->saveAddress($input->address, $userId, 'User');

        return $this->getUserDetail($userId);
    }

    private function updateConsultant($input, $userId)
    {
        $profileType = $this->getUserProfileType($userId);

        $consultant = $this->saveConsultant($input->consultant, $userId);

        if ($input->address)
            $this->saveAddress($input->address, $userId, 'User');

        return $this->getUserDetail($userId);
    }

    private function updateContractorAndConsultant($input, $userId)
    {
        $profileType = $this->getUserProfileType($userId);

        $contractorAndConsultant = $this->saveContractorAndConsultant($input->contractorAndConsultant, $userId);

        $this->saveAddress($input->address, $userId, 'User');

        return $this->getUserDetail($userId);
    }

    private function updateSupplier($input, $userId)
    {
        $supplier = $this->saveSupplier($input->supplier, $userId);

        if ($input->address)
            $this->saveAddress($input->address, $userId, 'User');
        if ($input->category_ids)
            $this->attachCategories($supplier, $input->category_ids);

        return $this->getUserDetail($userId);
    }

    private function updateProfessional($input, $userId)
    {
        $professional = $this->saveProfessional($input->professional, $userId);

        $this->saveAddress($input->address, $userId, 'User');

        $this->deleteEducations($professional);
        $this->deleteExperiences($professional);
        $this->deleteSkills($professional);

        foreach ($input->educations as $education) {
            $this->saveEducation($education, $professional->id);
        }

        foreach ($input->experiences as $experience) {
            $this->saveExperience($experience, $professional->id);
        }

        foreach ($input->skills as $skill) {
            $this->saveSkill($skill, $professional->id);
        }

        return $this->getUserDetail($userId);
    }

    private function updateEmployee($input, $userId)
    {
        $professional = $this->saveEmployee($input, $userId);

        $this->saveAddress($input->address, $userId, 'User');

        $this->deleteEducations($professional);
        $this->deleteExperiences($professional);
        $this->deleteSkills($professional);

        foreach ($input->educations as $education) {
            $this->saveEducation($education, $professional->id);
        }

        foreach ($input->experiences as $experience) {
            $this->saveExperience($experience, $professional->id);
        }

        foreach ($input->skills as $skill) {
            $this->saveSkill($skill, $professional->id);
        }

        return $this->getUserDetail($userId);
    }

    private function updateProjectOwner($input, $userId)
    {
        $this->saveProjectOwner($input->projectOwner, $userId);

        $this->saveAddress($input->address, $userId, 'User');

        return $this->getUserDetail($userId);
    }

    public function getStatistics()
    {
        $response = array('profileType' => array(), 'subscriptionPackage' => array());

        $profileType = $this->userProfileType();
        $subscriptionPackages = UserSubscriptionPackage::all();
        $subscriptionPackagesList = UserSubscriptionPackage::lists('package', 'price');


        $response["profileType"]["categories"] = array_values($profileType);
        $response["subscriptionPackage"]["categories"] = $subscriptionPackagesList->values();
        $response["profileType"]["series"] = array();
        $response["subscriptionPackage"]["series"] = array();
        $response["subscriptionPackage"]["packages"] = $subscriptionPackages;

        //Pie Chart Options
        $responseEach["type"] = "pie";
        $responseEach["colorByPoint"] = true;
        $responseEach["innerSize"] = '40%';

        foreach ($profileType as $key => $value) {

            $sector = array("name" => $value, "y" => 0);

            $sector["y"] = User::where(['profile_type' => $key])->count();

            if ($sector["y"] != 0) {
                $responseEach["data"][] = $sector;
            }


        }
        $response["profileType"]["series"][] = $responseEach;

        //Pie Chart Options
        $responseEach["type"] = "pie";
        $responseEach["colorByPoint"] = true;
        $responseEach["data"] = [];
        $responseEach["innerSize"] = '40%';
        foreach ($subscriptionPackagesList as $price => $package) {
            $users = User::all();
            $count = 0;
            foreach ($users as $user) {
                $subscription = UserSubscription::where(["user_id" => $user->id])->where('expiration_date', '>=', \Carbon\Carbon::now())->latest()->first();
                if ($subscription) {
                    if ($subscription->package->package === $package) {
                        $count++;
                    }
                }
            }
            $sector = array("name" => $package, "y" => $count, "price" => (float)($count * $price));
            if ($sector["y"] != 0) {
                $responseEach["data"][] = $sector;
            }

        }
        $response["subscriptionPackage"]["series"][] = $responseEach;

        return $response;
    }

    private function userProfileType()
    {
        return [
            'Contractor' => 'Contractor',
            'Consultant' => 'Consultant',
            'ContractorAndConsultant' => 'Contractor And Consultant',
            'ProjectOwner' => 'Project Owner',
            'Professional' => 'Professional',
            'Supplier' => 'Supplier'
        ];
    }

    public function getUserGroups($id, $per_page)
    {
        $groups = $this->getUserProfile($id)->groups()->latest()
            ->paginate($per_page);

        return $groups;
    }

    public function getAllGroups($id)
    {
        $groups = $this->getUserProfile($id)->groups()->get();
        return $groups;
    }




}
