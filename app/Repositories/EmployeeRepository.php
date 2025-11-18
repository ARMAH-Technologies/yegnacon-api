<?php
/**
 * Created by PhpStorm.
 * User: Yohannis Molla
 * Date: 5/23/2017
 * Time: 9:24 AM
 */

namespace App\Repositories;


use App\Entities\Address;
use App\Entities\Company;
use App\Entities\Contractor;
use App\Entities\Education;
use App\Entities\Employee;
use App\Entities\EmployeeLeaveRequest;
use App\Entities\Experience;
use App\Entities\Leave;
use App\Entities\Skill;
use App\Entities\Users\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class EmployeeRepository
{
    public function getAllEmployees($company_id){
        $company = $this->findCompany($company_id);
        $employees = [];
        $i = 0;
        foreach($company->employees as $employee){
            $employee->name = $employee->user->name;
            $employee->status = $employee->user->status;
            $employees[$i] = $employee;
            $i++;
        }
        return $employees;
    }

    public function getEmployeeDetail($employee_id, $company_id){
        $company = $this->findCompany($company_id);
        if($company != null){
            $employee = Employee::find($employee_id);
            $date = new \DateTime($employee->employment_date);
            $da = $date->format('Y-m-d');

            $employee->employment_date = $da;
            $employee->name = $employee->user->name;
            $employee->status = $employee->user->status;

            $temp = $employee->user->address;
            $employee['user'] = $employee->user;

            return $employee;
        }
        return null;
    }

    public function addNewEmployee($company_id, $input){
        if(isset($company_id)){
            $company = $this->findCompany($company_id);
            $date = new \DateTime($input['employment_date']);
            $date->add(new \DateInterval('PT3H'));
            if(!$company == null){
                $id = Uuid::generate(4);

                $employee = Employee::create([
                    'id' => $id,
//                    'full_name' => $input['full_name'],
                    'employment_title' =>  $input['employment_title'],
                    'employer_id' =>  $input['employer_id'],
                    'employment_date' =>  $date,
                    'employment_type' =>  $input['employment_type']
                ]);

                $employee = Employee::findOrFail($id);

                if(isset($input['skills'])){
                    foreach($input['skills'] as $skill){
                        $ski= $this->makeSkill($skill);
                        $employee->skills()->save($ski);
                    }
                }


                if(isset($input['experiences'])){
                    foreach($input['experiences'] as $experience){
                        $ex= $this->makeExperience($experience);
                        $employee->experiences()->save($ex);
                    }
                };

                if(isset($input['educations'])){
                    foreach($input['educations'] as $education){
                        $ed = $this->makeEducation($education);
                        $employee->educations()->save($ed);
                    }
                }

                if(isset($input['user'])){
                    $user = $this->makeUser($input['user']);
                    $employee->user_id = $user->id;
                }

                $leave_input = ['company_id' => $company_id, 'employee_id' => $id, 'fiscal_year' => Carbon::now()];
                $this->addLeaveToEmployee($leave_input);


                $employee->save();

                $company->employees()->save($employee);
                $result = ['msg' => 'Success', 'employee' => $employee];
                return $result;
            }
            $result = ['msg' => 'Company not found'];
            return $result;
        }
        $result = ['msg' => 'Missing company id'];
        return $result;
    }

    public function makeUser($input)
    {

        $user = new User();
        $user->id = $id = Uuid::generate(4);
        if(isset($input['name'])){ $user->name = $input['name'];}
        if(isset($input['email'])){ $user->email = $input['email'];}
        if(isset($input['password'])){ $user->password = Hash::make($input['password']);}
        if(isset($input['profile_type'])){ $user->profile_type = $input['profile_type'];}
        if(isset($input['status'])){ $user->status = $input['status'];}
        $user->save();
        $user = User::find($id);

        if(isset($input["address"])){
            $address = $this->saveAddress($input['address'], $id, null);
        }

        $user->save();
        return $user;
    }

    public function makeSkill($input){
        //dd($input);
        $id = Uuid::generate(4);
        Skill::create([
            'id' => $id,
            'skill' => $input
        ]);

        $skill = Skill::findOrFail($id);
        return $skill;
    }

    public function makeExperience($input){
        $id = Uuid::generate(4);
        Experience::create([
            'id' => $id,
            'company' => $input['company'],
            'position' => $input['position'],
            'description' => $input['description'],
            'started_date' => $input['started_date'],
            'ended_date' => $input['ended_date'],
        ]);

        $experience = Experience::findOrFail($id);
        return $experience;
    }

    public function makeEducation($input){
        $id = Uuid::generate(4);
        Education::create([
            'id' => $id,
            'study_field' => $input['study_field'],
            'grad_level' => $input['grade_level'],
            'school_name' => $input['school_name'],
            'started_date' => $input['started_date'],
            'ended_date' => $input['ended_date'],
        ]);

        $education = Education::findOrFail($id);
        return $education;
    }

    public function updateEmployeeDetail($employee_id, $company_id, $input){
        if(isset($company_id)){
            $company = $this->findCompany($company_id);
            if($company != null) {
                $employee = Employee::findOrFail($employee_id);

                if (isset($input['employment_title'])) {
                    $employee->employment_title = $input['employment_title'];
                }
                if (isset($input['full_name'])) {
//                    $employee->employment_title = $input['full_name'];
                }
                if (isset($input['employer_id'])) {
                    $employee->employer_id = $input['employer_id'];
                }
                if (isset($input['employment_date'])) {
                    $date = new \DateTime($input['employment_date']);
                    $date->add(new \DateInterval('PT3H'));
                    $da = $date->format('Y-m-d');
                    $employee->employment_date = $da;
                }
                if (isset($input['employment_type'])) {
                    $employee->employment_type = $input['employment_type'];
                }

                if (isset($input['user'])) {
                    $user_id = $employee->user->id;
                    $this->updateUser($input['user'], $user_id);
                }


                if (isset($input['skills'])) {
                    foreach ($employee->skills as $skill) {
                        foreach ($input['skills'] as $input_skill) {
                            if ($skill->id == $input_skill['id']) {
                                $this->updateSkill($input_skill, $skill->id);
                            }
                        }
                    }
                }


                if (isset($input['experiences'])) {
                    foreach ($employee->experiences as $experience) {
                        foreach ($input['experiences'] as $input_experience) {
                            if ($experience->id == $input_experience['id']) {
                                $this->updateExperience($input_experience, $experience->id);
                            }
                        }
                    }
                }

                if (isset($input['educations'])) {
                    foreach ($employee->educations as $education) {
                        foreach ($input['educations'] as $input_education) {
                            if ($education->id == $input_education['id']) {
                                $this->updateEducation($input_education, $education->id);
                            }
                        }
                    }
                }
                $employee->save();
                $result = ['msg' => 'success', 'employee' => $employee];
                return $result;
            }
            $result = ['msg' => 'Company not found'];
            return $result;
        }
        $result = ['msg' => 'Missing company id'];
        return $result;
    }

    public function updateUser($input, $id)
    {

        $user = User::find($id);
        if(isset($input['name'])){ $user->name = $input['name'];}
        if(isset($input['email'])){ $user->email = $input['email'];}
        if(isset($input['password'])){ $user->password = Hash::make($input['password']);}
        if(isset($input['profile_type'])){ $user->profile_type = $input['profile_type'];}
        if(isset($input['status'])){ $user->status = $input['status'];}
        $address_id = $user->address->id;
        if(isset($input["address"])){
            $this->saveAddress($input['address'], null, $address_id);
            //$user->address = $address;
        }
        $user->save();
        return $user;
    }

    public function updateSkill($input, $id){
        if (isset($id)) {
            $skill = Skill::findOrFail($id);
            if (isset($input)) {
                $skill->skill = $input;
            }

            $skill->save();
            return $skill;
        }
        return null;
    }

    public function updateExperience($input, $id){
        if(isset($id)){
            $experiance = Experience::findOrFail($id);
            if (isset($input['company'])) {$experiance->company = $input['company'];}
            if (isset($input['position'])) {$experiance->position = $input['position'];}
            if (isset($input['description'])) {$experiance->description = $input['description'];}
            if (isset($input['started_date'])) {$experiance->started_date = $input['started_date'];}
            if (isset($input['ended_date'])) {$experiance->ended_date = $input['ended_date'];}

            $experiance->save();
            return $experiance;
        }
        return null;
    }

    public function updateEducation($input, $id){
        if(isset($id)){
            $education = Education::findOrFail($id);
            if (isset($input['study_field'])) {$education->study_field = $input['study_field'];}
            if (isset($input['grade_level'])) {$education->grad_level = $input['grade_level'];}
            if (isset($input['school_name'])) {$education->school_name = $input['school_name'];}
            if (isset($input['started_date'])) {$education->started_date = $input['started_date'];}
            if (isset($input['ended_date'])) {$education->ended_date = $input['ended_date'];}

            $education->save();
            return $education;
        }
        return null;
    }

    public function removeEmployee($company_id, $employee_id){
        $company = $this->findCompany($company_id);
        if($company != null){
            $employee = Employee::find($employee_id);
            //$company->employees()->delete($employee);
            $employee->delete();
            return "Successfully Deleted";
        }
        return false;
    }

    public function saveAddress($input, $user_id, $address_id)
    {
        if (isset($address_id)) {

            $id = $address_id;
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
            return $address;
        } else {
            $address = new Address();
            $address->id = $id = Uuid::generate(4);
            $address->item_id = $user_id;
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
            return $address;
        }
    }

    ////////////////////////////////////////////////
    //leaves requests

    public function addLeaveToEmployee($input){

        $company = $this->findCompany($input['company_id']);
        $employee = Employee::find($input['employee_id']);
        foreach($company->leaves as $leave){
            $val = $leave->pivot->value;
            $employee->leaves()->attach($leave, ['value2' => $val, 'fiscal_year' => $input['fiscal_year']]);
        }

        return $employee;
    }

    public function employeeLeaveDetail($input)
    {
        $employee= Employee::findOrFail($input);

        $result = [];
        foreach($employee->leaves as $leave){
            $result[$leave->name] = $leave->pivot->value2;
        }

        return $result;
    }

    public function employeeLeaveRequestHistory($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $all_requests = [];
        $i = 1;
        foreach($employee->leaveRequests as $request){
            $leave = Leave::find($request->leave_id);
            $sd = new \DateTime($request->start_date);
            //$ed = new \DateTime($request->start_date);

            $sdf = $sd->format('m/d/Y');
           // $edf = $ed->format('Y-m-d');
            $temp = [
                'no' => $i,
                'id' => $request->id,
                'leave_name' => $leave->name,
                'leave_id' => $request->leave_id,
                'start_date' => $sdf,
                //'end_date' => $edf,
                'number_of_days' => $request->number_of_days,
                'status' => $request->status,
                'remark' => $request->remark,
                'approved_date' => $request->approved_date
            ];
            $i++;
            $all_requests[] = $temp;
        }

        return $all_requests;
    }

    public function addEmployeeLeaveRequest($input, $employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $leave = Leave::findOrFail($input['leave_id']);
        foreach ($employee->leaves as $emp_leave) {
            if ($emp_leave->id == $leave->id) {
                $value = $emp_leave->pivot->value2;

                $new_value = $value - $input['number_of_days'];

                if($new_value < 0){
                    $result = [
                        'possibility' => 'No',
                        'remain_date' => $value
                    ];
                    return $result;
                }

                $id = Uuid::generate(4);
                $sd = new \DateTime($input['start_date']);
                $sd->add(new \DateInterval('PT4H'));

                EmployeeLeaveRequest::create([
                    'id' => $id,
                    'approved_date' => null,
                    'start_date' => $sd,
                    'number_of_days' => $input['number_of_days'],
                    // 'end_date' => null,
                    'status' => 'Pending',
                    'remark' => $input['remark']
                ]);

                $employee_leave = EmployeeLeaveRequest::findOrFail($id);
                $leave->employeeLeaveRequest()->save($employee_leave);
                $employee->leaveRequests()->save($employee_leave);
                return $employee_leave;
            }
        }
        return false;
    }

    public function updateEmployeeLeaveRequest($input, $employee_id, $request_id)
    {
        if(isset($employee_id)) {

            $employee = Employee::findOrFail($employee_id);

            $request = EmployeeLeaveRequest::findOrFail($request_id);


            if (isset($input['approved_date'])) {
                $request->approved_date = Carbon::now();
            }
            if (isset($input['number_of_days'])) {
                $request->number_of_days = $input['number_of_days'];
            }
            if (isset($input['start_date'])) {

                $sd = new \DateTime($input['start_date']);
                $sd->add(new \DateInterval('PT3H'));
                $request->start_date = $sd;
            }
            if (isset($input['leave_id'])) {
                $leave = Leave::findOrFail($input['leave_id']);
                $request->leave = $leave;
            }
            if (isset($input['status']) && $input['status'] == "Approved") {

                $request->status = $input['status'];
                $value = $request->number_of_days;
                $leave_id = $request->leave_id;
                $this->approveRequest($employee_id, $leave_id, $value);
            }if (isset($input['status']) && $input['status'] == "Denied") {

                $request->status = $input['status'];
                //$value = $request->number_of_days;
                //$leave_id = $request->leave_id;
                //$this->approveRequest($employee_id, $leave_id, $value);
            }
            if (isset($input['remark'])) {
                $request->remark = $input['remark'];
            }


            $request->save();
            return $request;
        }
        return null;
    }

    public function deleteEmployeeLeaveRequest($employee_id, $request_id)
    {
        if(isset($employee_id)) {

            //$employee = Employee::findOrFail($employee_id);
            $request = EmployeeLeaveRequest::findOrFail($request_id);

           // $employee->leaveRequests()->delete($request);

            $request->delete();
            return "Successfully Deleted";
        }
        return false;
    }

    public function approveRequest($employee_id, $leave_id, $given_value)
    {
        $employee = Employee::findOrFail($employee_id);
        foreach ($employee->leaves as $leave) {
            if ($leave->id == $leave_id) {
                $value = $leave->pivot->value2;

                $new_value = $value - $given_value;

                if($new_value < 0){
                    $result = [
                        'possibility' => 'No',
                        'remain_date' => $value
                    ];
                    return $result;
                }

                $employee->leaves()->updateExistingPivot($leave_id, ['value2' => $new_value]);
                return true;
            }
        }
        return false;
    }

    public function allRequests($company_id){
        $company = $this->findCompany($company_id);

        $all_requests = [];

        foreach ($company->employees as $employee) {
            $date = new \DateTime($employee->employment_date);
            $da = $date->format('Y-m-d');
            $requests = [];
            foreach($employee->leaveRequests as $request){
                $leave = Leave::find($request->leave_id);
                $sd = new \DateTime($request->start_date);

                $sdf = $sd->format('m/d/Y');
                //$edf = $ed->format('Y-m-d');
                $temp = [
                    'id' => $request->id,
                    'leave_name' => $leave->name,
                    'leave_id' => $request->leave_id,
                    'start_date' => $sdf,
                    'number_of_days' => $request->number_of_days,
                    'status' => $request->status,
                    'remark' => $request->remark,
                    'approved_date' => $request->approved_date
                ];
                $all_requests[] = [
                    'request' => $temp,
                    'name' => $employee->user->name,
                    'employment_title' => $employee->employment_title,
                    'employment_date' => $da,
                    'employee_id' => $employee->id,
                ];
            }

//            $all_requests[$employee->id] = [
//                'requests' => $requests,
//                'name' => $employee->user->name,
//                'employment_title' => $employee->employment_title,
//                'employment_date' => $da,
//            ];
        }
        return $all_requests;

    }

    public function findCompany($company_id){
        $user = User::findorFail($company_id);
        if(isset($user)){
            if($user->profile_type == "Contractor"){
                $company = $user->contractor;
                return $company;
            }else if($user->profile_type == "Supplier"){
                $company = $user->supplier;
                return $company;
            }else if($user->profile_type == "Consultant"){
                $company = $user->consultant;
                return $company;
            }else{
                return "Company not found!";
            }
        }
        return "Invalid id";
    }

    public function getEmployeeSkills($employee_id){
        $employee = Employee::find($employee_id);
        return $employee->skills()->get()->toArray();
    }

    public function getEmployeeEducations($employee_id){
        $employee = Employee::find($employee_id);
        return $employee->educations()->get()->toArray();
    }

    public function getEmployeeExperiences($employee_id){
        $employee = Employee::find($employee_id);
        return $employee->experiences()->get()->toArray();
    }

    public function getData($userId){


        $user = User::find($userId);

        $employee_id = $user->employee->id;
        $employee = Employee::find($employee_id);

        $user = $employee->user;
        $address = $employee->user->address;

        $company_id = $employee->employer_id;
       // dd($company_id);
        $result = [
            'user' => $user,
            'company_id' => $company_id,
            'employee_id' => $employee_id,
//            'fullName' => $employee->full_name
        ];

        return $result;
    }


    public function requestDetail($request_id){
        $request = EmployeeLeaveRequest::find($request_id);
        $leave_id = $request->leave_id;

        $leave = Leave::find($leave_id);

        $da = $request->leave_id;
        $date = date('m/d/Y');

        $result = [
            'request' => $request,
            'leave' => $leave,
            'date' => $date,
        ];
        return $result;
    }

    public function getCompanyData($userId)
    {
        return $this->findCompany($userId);
    }
}
