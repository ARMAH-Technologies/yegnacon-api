<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 3/13/2016
 * Time: 5:52 PM
 */

namespace App\Repositories;

use App\Entities\Address;
use App\Entities\Company;
use App\Entities\Consultant;
use App\Entities\Contractor;
use App\Entities\ContractorAndConsultant;
use App\Entities\Education;
use App\Entities\Employee;
use App\Entities\Experience;
use App\Entities\Professional;
use App\Entities\Project;
use App\Entities\ProjectOwner;
use App\Entities\Skill;
use App\Entities\Supplier;
use App\Entities\Users\User;
use App\Entities\UserSubscription;
use App\Entities\UserSubscriptionPackage;
use App\Repositories\LeaveRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hashm;
use Webpatser\Uuid\Uuid;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

trait UserTrait
{
    public function saveUser($input)
        {
            $status = null;
            if($input['profile_type'] === 'Professional' || $input['profile_type'] === 'ProjectOwner'){
                $status = 'active';
            }else if($input['profile_type'] === 'Employee'){
                $status = 'Employed';
            }else{
                $status = 'inactive';
            }
            $user = new User();
            $user->id = $id = Uuid::generate(4);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->profile_type = $input['profile_type'];
            $user->status = $status;
            $user->save();

            $user = User::find($id);
          

            if($user->profile_type === 'Professional' || $user->profile_type === 'ProjectOwner') {
               /* Mail::queue('emails.welcome', ['name' => $user->name], function($message) use($user){
                    $message->to($user->email)->subject('Welcome to Yegnacon, '.$user->name);
                });*/
            } else {
              /*  Mail::queue('emails.welcome_subscribe', ['name' => $user->name], function($message) use($user){
                    $message->to($user->email)->subject('Welcome to Yegnacon, '.$user->name);
                });*/
            }
            $this->saveProfile($input, $user->id);

            return $user;
        }

    public function saveProfile($input, $user_id)
    {
        $profileType = User::find($user_id)->profile_type;
        $profile = null;

        if ($profileType === 'Contractor') {
            $profile = $this->saveContractor(null, $user_id);
        } else if ($profileType === 'Supplier') {
            $profile = $this->saveSupplier(null, $user_id);
        }else if ($profileType === 'Consultant') {
            $profile = $this->saveConsultant(null, $user_id);
        } else if ($profileType === 'Professional') {
            $profile = $this->saveProfessional(null, $user_id);
        } else if ($profileType === 'ProjectOwner') {
            $profile = $this->saveProjectOwner(null, $user_id);
        }else if ($profileType === 'Employee') {
            $profile = $this->saveEmployee($input, $user_id);
        }

        return $profile;
    }
    public function saveEmployee($input, $userId = null){
        if (isset($input['id'])) {
            $id = $input['id'];
            $employee = Employee::find($id);

            $employee->employment_title = isset($input['employment_title']) ? $input['employment_title'] : $employee->employment_title;
            $employee->employer_id = isset($input['employer_id']) ? $input['employer_id'] : $employee->employer_id;
            $employee->employment_date = isset($input['employment_date']) ? $input['employment_date'] : $employee->employment_date;
            $employee->employment_type = isset($input['employment_type']) ? $input['employment_type'] : $employee->employment_type;
            $employee->company_id = isset($input['company_id']) ? $input['company_id'] : $employee->company_id;

            $employee->save();
        } else {
            $employee = new Employee();
            $employee->id = $id = Uuid::generate(4);
            $employee->user_id = $userId;

            $employee->employment_title = isset($input['employment_title']) ? $input['employment_title'] : $employee->employment_title;
            $employee->employer_id = isset($input['employer_id']) ? $input['employer_id'] : $employee->employer_id;
            $employee->employment_date = isset($input['employment_date']) ? $input['employment_date'] : $employee->employment_date;
            $employee->employment_type = isset($input['employment_type']) ? $input['employment_type'] : $employee->employment_type;
            $employee->company_id = isset($input['company_id']) ? $input['company_id'] : $employee->company_id;

            $employee->save();
        }

        return $employee::find($id);
    }

    public function saveContractor($input, $userId = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $contractor = Contractor::find($id);

            $contractor->type = isset($input['type']) ? $input['type'] : $contractor->type;
            $contractor->level = isset($input['level']) ? $input['level'] : $contractor->level;
            $contractor->established_year = isset($input['established_year']) ? $input['established_year'] :
                $contractor->established_year;
            $contractor->description = isset($input['description']) ? $input['description'] : $contractor->description;
            $contractor->save();
            $contractor = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($contractor);
            $contractor->save();
        } else {

            $contractor = new Contractor();
            $contractor->id = $id = Uuid::generate(4);
            $contractor->user_id = $userId;
            $contractor->type = isset($input['type']) ? $input['type'] : null;
            $contractor->level = isset($input['level']) ? $input['level'] : null;
            $contractor->established_year = isset($input['established_year']) ? $input['established_year'] : null;
            $contractor->description = isset($input['description']) ? $input['description'] : null;
            $contractor->save();

            $contractor = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($contractor);
            $contractor->save();
        }

        return Contractor::find($id);
    }

    public function saveConsultant($input, $userId = null)
    {

        if (isset($input['id'])) {
            $id = $input['id'];
            $consultant = Consultant::find($id);
            $consultant->type = isset($input['type']) ? $input['type'] : $consultant->type;
            $consultant->level = isset($input['level']) ? $input['level'] : $consultant->level;
            $consultant->established_year = isset($input['established_year']) ? $input['established_year'] :
                $consultant->established_year;
            $consultant->description = isset($input['description']) ? $input['description'] : $consultant->description;
            $consultant->save();
            $consultant = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($consultant);
            $consultant->save();
        } else {
            $consultant = new Consultant();
            $consultant->id = $id = Uuid::generate(4);
            $consultant->user_id = $userId;
            $consultant->type = isset($input['type']) ? $input['type'] : null;
            $consultant->level = isset($input['level']) ? $input['level'] : null;
            $consultant->established_year = isset($input['established_year']) ? $input['established_year'] : null;
            $consultant->description = isset($input['description']) ? $input['description'] : null;
            $consultant->save();

            $consultant = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($consultant);
            $consultant->save();
        }

        return Consultant::find($id);
    }

    public function saveContractorAndConsultant($input, $userId = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $contractorAndConsultant = ContractorAndConsultant::find($id);
            $contractorAndConsultant->type = isset($input['type']) ? $input['type'] : $contractorAndConsultant->type;
            $contractorAndConsultant->level = isset($input['level']) ? $input['level'] : $contractorAndConsultant->level;
            $contractorAndConsultant->established_year = isset($input['established_year']) ? $input['established_year'] : $contractorAndConsultant->established_year;
            $contractorAndConsultant->description = isset($input['description']) ? $input['description'] : $contractorAndConsultant->description;
            $contractorAndConsultant->save();
        } else {
            $contractorAndConsultant = new ContractorAndConsultant();
            $contractorAndConsultant->id = $id = Uuid::generate(4);
            $contractorAndConsultant->user_id = $userId;
            $contractorAndConsultant->type = isset($input['type']) ? $input['type'] : null;
            $contractorAndConsultant->level = isset($input['level']) ? $input['level'] : null;
            $contractorAndConsultant->established_year = isset($input['established_year']) ? $input['established_year'] : null;
            $contractorAndConsultant->description = isset($input['description']) ? $input['description'] : null;
            $contractorAndConsultant->save();
        }

        return ContractorAndConsultant::find($id);
    }

    public function saveProfessional($input, $userId)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $professional = Professional::find($id);
            $professional->professional_title = isset($input['professional_title']) ? $input['professional_title'] :
                $professional->professional_title;
            $professional->birth_date = isset($input['birth_date']) ? $input['birth_date'] : $professional->birth_date;
            $professional->gender = isset($input['gender']) ? $input['gender'] : $professional->gender;
            $professional->nationality = isset($input['nationality']) ? $input['nationality'] : $professional->nationality;
            $professional->biography = isset($input['biography']) ? $input['biography'] : $professional->biography;
            $professional->save();
        } else {
            $professional = new Professional();
            $professional->id = $id = Uuid::generate(4);
            $professional->user_id = $userId;
            $professional->professional_title = isset($input['professional_title']) ? $input['professional_title'] : null;
            $professional->birth_date = isset($input['birth_date']) ? $input['birth_date'] : null;
            $professional->gender = isset($input['gender']) ? $input['gender'] : null;
            $professional->nationality = isset($input['nationality']) ? $input['nationality'] : null;
            $professional->biography = isset($input['biography']) ? $input['biography'] : null;
            $professional->save();
        }

        return Professional::find($id);
    }

    public function saveSupplier($input, $userId = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $supplier = Supplier::find($id);
            $supplier->established_year = isset($input['established_year']) ? $input['established_year'] :
                $supplier->established_year;
            $supplier->description = isset($input['description']) ? $input['description'] : $supplier->description;
            $supplier->save();
            $supplier = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($supplier);
            $supplier->save();
        } else {
            $supplier = new Supplier();
            $supplier->id = $id = Uuid::generate(4);
            $supplier->user_id = $userId;
            $supplier->established_year = isset($input['established_year']) ? $input['established_year'] : null;
            $supplier->description = isset($input['description']) ? $input['description'] : null;
            $supplier->save();
            $supplier = \App\Repositories\LeaveRepository::giveDefaultLeaveToACompany($supplier);
            $supplier->save();
        }

        return Supplier::find($id);
    }

    public function saveProjectOwner($input, $userId = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $projectOwner = ProjectOwner::find($id);
            $projectOwner->type = isset($input['type']) ? $input['type'] : $projectOwner->type;
            $projectOwner->save();
        } else {
            $projectOwner = new ProjectOwner();
            $projectOwner->id = $id = Uuid::generate(4);
            $projectOwner->user_id = $userId;
            $projectOwner->type = isset($input['type']) ? $input['type'] : null;
            $projectOwner->save();
        }

        return ProjectOwner::find($id);
    }

    public function saveCompany($input)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $company = Company::find($id);
            $company->name = $input['name'];
            $company->email = isset($input['email']) ? $input['email'] : $company->email;
            $company->save();
        } else {
            $company = new Company();
            $company->id = $id = Uuid::generate(4);
            $company->name = $input['name'];
            $company->email = isset($input['email']) ? $input['email'] : null;
            $company->save();
        }

        return Company::find($id);
    }

    public function saveAddress($input, $itemId, $item_type)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $address = Address::find($id);
            $address->website = isset($input['website']) ? $input['website'] : $address->website;
            $address->phone_number_1 = isset($input['phone_number_1']) ? $input['phone_number_1'] : $address->phone_number_1;
            $address->phone_number_2 = isset($input['phone_number_2']) ? $input['phone_number_2'] : $address->phone_number_2;
            $address->country = isset($input['country']) ? $input['country'] : $address->country;
            $address->city = isset($input['city']) ? $input['city'] : $address->city;
            $address->sub_city = isset($input['sub_city']) ? $input['sub_city'] : $address->sub_city;
            $address->house_no = isset($input['house_no']) ? $input['house_no'] : $address->house_no;
            $address->specific_address = isset($input['specific_address']) ? $input['specific_address'] : $address->specific_address;
            $address->latitude = isset($input['latitude']) ? $input['latitude'] : $address->latitude;
            $address->longitude = isset($input['longitude']) ? $input['longitude'] : $address->longitude;
            $address->facebook_link = isset($input['facebook_link']) ? $input['facebook_link'] : $address->facebook_link;
            $address->twitter_link = isset($input['twitter_link']) ? $input['twitter_link'] : $address->twitter_link;
            $address->linkidin_link = isset($input['linkidin_link']) ? $input['linkidin_link'] : $address->linkidin_link;
            $address->google_link = isset($input['google_link']) ? $input['google_link'] : $address->google_link;
            $address->instagram_link = isset($input['instagram_link']) ? $input['instagram_link'] : $address->instagram_link;
            $address->save();
        } else {
            $address = new Address();
            $address->id = $id = Uuid::generate(4);
            $address->item_id = $itemId;
            $address->item_type = $item_type;
            $address->website = isset($input['website']) ? $input['website'] : null;
            $address->phone_number_1 = isset($input['phone_number_1']) ? $input['phone_number_1'] : null;
            $address->phone_number_2 = isset($input['phone_number_2']) ? $input['phone_number_2'] : null;
            $address->country = isset($input['country']) ? $input['country'] : null;
            $address->city = isset($input['city']) ? $input['city'] : null;
            $address->sub_city = isset($input['sub_city']) ? $input['sub_city'] : null;
            $address->house_no = isset($input['house_no']) ? $input['house_no'] : null;
            $address->specific_address = isset($input['specific_address']) ? $input['specific_address'] : null;
            $address->latitude = isset($input['latitude']) ? $input['latitude'] : null;
            $address->longitude = isset($input['longitude']) ? $input['longitude'] : null;
            $address->facebook_link = isset($input['facebook_link']) ? $input['facebook_link'] : null;
            $address->twitter_link = isset($input['twitter_link']) ? $input['twitter_link'] : null;
            $address->linkidin_link = isset($input['linkidin_link']) ? $input['linkidin_link'] : null;
            $address->google_link = isset($input['google_link']) ? $input['google_link'] : null;
            $address->instagram_link = isset($input['instagram_link']) ? $input['instagram_link'] : null;
            $address->save();
        }
    }

    public function saveEducation($input, $professional_id)
    {
        $education = new Education();

        $education->id = $id = Uuid::generate(4);
        $education->professional_id = $professional_id;
        $education->study_field = isset($input['study_field']) ? $input['study_field'] : null;
        $education->grad_level = isset($input['grad_level']) ? $input['grad_level'] : null;
        $education->school_name = isset($input['school_name']) ? $input['school_name'] : null;
        $education->started_date = isset($input['started_date']) ? $input['started_date'] : null;
        $education->ended_date = isset($input['ended_date']) ? $input['ended_date'] : null;

        $education->save();
    }

    public function addExperience($input, $professional_id){
        $professional = Professional::find($professional_id);
        $this->saveExperience($input, $professional_id);
        return $professional;
    }

    public function saveExperience($input, $professional_id)
    {
        $experience = new Experience();

        $experience->id = $id = Uuid::generate(4);
        $experience->professional_id = $professional_id;
        $experience->company = isset($input['company']) ? $input['company'] : null;
        $experience->position = isset($input['position']) ? $input['position'] : null;
        $experience->description = isset($input['description']) ? $input['description'] : null;
        $experience->started_date = isset($input['started_date']) ? $input['started_date'] : null;
        $experience->ended_date = isset($input['ended_date']) ? $input['ended_date'] : null;

        $experience->save();
    }

    public function saveSkill($input, $professional_id)
    {
        $skill = new Skill();

        $skill->id = $id = Uuid::generate(4);
        $skill->professional_id = $professional_id;
        $skill->skill = isset($input['skill']) ? $input['skill'] : null;

        $skill->save();
    }

    public function saveProject($input, $profileId = null, $profileType = null)
    {
        if (isset($input['id'])) {
            $id = $input['id'];
            $project = Project::find($id);
            $project->name = $input['name'];
            $project->category = isset($input['category']) ? $input['category'] :  $project->category;
            $project->client = isset($input['client']) ? $input['client'] : $project->client;
            $project->description = isset($input['description']) ? $input['description'] : $project->description;
            $project->elapsed_time = isset($input['elapsed_time']) ? $input['elapsed_time'] : $project->elapsed_time;
            $project->cost = isset($input['cost']) ? $input['cost'] : $project->cost;
            $project->location = isset($input['location']) ? $input['location'] : $project->location;
            $project->save();
        } else {
            $project = new Project();
            $project->id = $id = Uuid::generate(4);
            $project->profile_id = $profileId;
            $project->profile_type = $profileType;
            $project->name = $input['name'];
            $project->category = isset($input['category']) ? $input['category'] : null;
            $project->client = isset($input['client']) ? $input['client'] : null;
            $project->description = isset($input['description']) ? $input['description'] : null;
            $project->elapsed_time = isset($input['elapsed_time']) ? $input['elapsed_time'] : null;
            $project->cost = isset($input['cost']) ? $input['cost'] : null;
            $project->location = isset($input['location']) ? $input['location'] : null;
            $project->save();
        }

        return Project::find($id);
    }

    public function deleteEducations($professional)
    {
        $professional->educations()->forceDelete();
    }

    public function deleteExperiences($professional)
    {
        $professional->experiences()->forceDelete();
    }

    public function deleteSkills($professional)
    {
        $professional->skills()->forceDelete();
    }

    public function deleteProjects($contractor)
    {
        $contractor->projects()->forceDelete();
    }

    public function attachCategories($supplier, $category_ids)
    {
        $supplier->proformaCategories()->detach();

        $supplier->proformaCategories()->attach($category_ids, ['type' => 'Proforma']);
    }

    protected function checkOldPassword($user_id, $password)
    {
        $oldPassword = crypt((string)($password),User::find($user_id)->password);

        if($oldPassword === User::find($user_id)->password){
            return true;
        }
        else {
            return false;
        }
    }

    protected function changePasswordT($user_id, $newPassword)
    {
        $user = User::find($user_id);
        $user->password = Hash::make((string)$newPassword);
        $user->save();
    }


    public function getUserSubscriptions($user_id){
        
    }

    public function subscribe($user_id,$sales_id,$package_id){
        //Get the package
        $package = UserSubscriptionPackage::find($package_id);


        $subscription = new UserSubscription();
        $subscription->user_id = $user_id;
        $subscription->subscription_package_id = $package_id;
        $subscription->sales_id = $sales_id;

        //Subscription Dates
        $subscription->started_date = Carbon::now();
        $currentDate = Carbon::now();

        $subscription->expiration_date = $currentDate->addMonth($package->duration_in_months);
        $subscription->save();

        $user = User::find($user_id);

        //Set user status to be Active
        $user->status = "active";
        $user->save();

        $user = User::find($user_id);

        $package_name = $package->package;
        $package_price = $package->price;
        $package_price_VAT = ($package_price * 0.15);
        $package_price_with_VAT = $package_price_VAT + $package_price;

        $arr = array('user_name' => $user->name,'email'=>$user->email, 'package_name' => $package_name, 'current_date' => $currentDate->toDateString(), 'expiration_date' => $currentDate->addMonth($package->duration_in_months)->toDateString(),
            'package_price' => $package_price, 'package_price_VAT' => $package_price_VAT,
            'package_price_with_VAT' => $package_price_with_VAT);
        
       /* Mail::queue('emails.invoice', ['data' => $arr], function($message) use($arr, $user) {
            $message->to($user->email)->subject('Subscription Invoice');
        });*/

        return $user;

    }
    /*
     * returns profileTypes as $key(Actual DB names), $value(Display name)
     */
    public function profileTypes(){
        return array(
            'Contractor' => 'Contractor',
            'Consultant' => 'Consultant',
            'ContractorAndConsultant' => 'Contractor And Consultant',
            'Supplier' => 'Supplier',
            'Company' => 'Admin'
        );
    }
}