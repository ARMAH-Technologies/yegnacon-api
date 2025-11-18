<?php
/**
 * Created by PhpStorm.
 * User: Yohannis Molla
 * Date: 5/23/2017
 * Time: 1:12 PM
 */

namespace App\Repositories;


use App\Entities\Company;
use App\Entities\Employee;
use App\Entities\EmployeeLeaveRequest;
use App\Entities\Leave;
use App\Entities\Users\User;
use Webpatser\Uuid\Uuid;
class LeaveRepository
{
    ////////////////////////////////////////////////////////////////////////////


    public function getAllLeaveTypes()
    {
        $leaves = Leave::all();
        return $leaves;
    }

    public function addNewLeaveType($input)
    {
        $id = Uuid::generate(4);
        Leave::create([
            'id' => $id,
            'name' => $input['name']
        ]);

        $leave = Leave::find($id);
        return $leave;
    }

    public function updateLeaveType($input, $leave_id)
    {
        $leave = Leave::find($leave_id);
        if (isset($input['name'])) {
            $leave->name = $input['name'];
        }
        $leave->save();
        return $leave;
    }

    public function deleteLeaveType($leave_id)
    {
        $leave = Leave::find($leave_id);

        $leave->delete();
        return "Successfully Deleted";
    }

    public function getCompanyLeaveValues($company_id)
    {
        $company = $this->findCompany($company_id);
        $leaves = [];
        $i = 0;
        foreach ($company->leaves as $leave) {
            $temp = [];
            $temp['id'] = $leave->id;
            $temp['name'] = $leave->name;
            $temp['value'] = $leave->pivot->value;
            $leaves[$i] = $temp;
            $i++;
        }
        return $leaves;
    }

    public function updateCompanyLeave($inputs, $company_id)
    {
        $company = $this->findCompany($company_id);
        //$leave = Leave::find($input['leave_id']);
        //dd($company);
        foreach($inputs as $input) {
            //dd($inputs);
            foreach ($company->leaves as $leave) {

                if ($leave->id == $input['leave_id']) {
//                if(isset($input['name'])){
//                    if($leave->name =! $input['name']){
//                        $input_l = ['name' => $input['name']];
//                        $leave = $this->updateLeaveType($input_l);
//                    }
//                }
                    //dd($input['value']);
                    $company->leaves()->updateExistingPivot($leave->id, ['value' => $input['value']]);
                    //$leave->pivot->value = $input['value'];

                   // dd('johhhhh');
                }
            }
            //return $this->getCompanyLeaveValues($company_id);
        }

        return "Not Updated";
    }

    public function addCompanyLeave($inputs, $company_id)
    {
        $company = $this->findCompany($company_id);

        foreach($inputs as $input){
            $leave = Leave::find($input['leave_id']);
            $company->leaves()->attach($leave, ['value' => $input['value']]);
        }
//        if(isset($input['name'])){
//            $input_l = ['name' => $input['name']];
//            $leave = $this->addNewLeaveType($input_l);
//            $company->leaves()->attach($leave, ['value' => $input['value']]);
//            return $leave;
//        }

        return $this->getCompanyLeaveValues($company_id);
    }

    public function deleteCompanyLeave($leave_id, $company_id)
    {
        $company = $this->findCompany($company_id);
        $leave = Leave::find($leave_id);
        $company->leaves()->detach($leave);
        return "Successfully Deleted";
    }

    public function getLeaveBalance($employee_id, $leave_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $leave_b = [];
        foreach ($employee->leaves as $leave) {
            if ($leave->id == $leave_id) {
                $leave_b['name'] = $leave->name;
                $leave_b['value'] = $leave->pivot->value2;
                return $leave_b;
            }
        }
        return null;
    }

    public function getAllLeaveBalance($company_id, $employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        //$employer_id = $employee->employer_id;
        //
        $company_leaves = $this->getCompanyLeaveValues($company_id);

        $leaves = [];
        $i = 1;
        foreach ($employee->leaves as $leave) {
            foreach($company_leaves as $c_leave){

                if($leave->id == $c_leave['id']){
                    //dd($leave->id);
                    $temp = [
                        'no' => $i,
                        'name' => $leave->name,
                        'total' => $c_leave['value'],
                        'remain' => $leave->pivot->value2,
                    ];
                    $leaves[] = $temp;
                }
            }
            $i++;
        }
        return $leaves;
    }

    public function giveDefaultLeaveToACompany($company){
        $leaves = Leave::all();
        if($company->profile_type == "Employee"){
            return "Employee Given";
        }else {
            foreach ($leaves as $leave) {
                if (!isset($company->leaves->pivot)) {
                    if ($leave->name == "Annual Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "Sick Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "Leave without pay") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "Marriage Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "Maternity Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "paternity Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } elseif ($leave->name == "Mourning Leave") {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    } else {
                        $company->leaves()->attach($leave, ['value' => 10]);
                    }
                }
            }
            return $company;
        }
    }

    public function giveDefaultLeaveToAll(){
        $users = User::all();
        foreach($users as $user){
            if($user->profile_type == "Contractor"){
                $company = $user->contractor;
                //dd($company);
                $this->giveDefaultLeaveToACompany($company);
            }else if($user->profile_type == "Supplier"){
                $company = $user->supplier;
                //dd($company);
                $this->giveDefaultLeaveToACompany($company);
            }else if($user->profile_type == "Consultant"){
                $company = $user->consultant;
                //dd($company);
//                dd($user);
//                $this->giveDefaultLeaveToACompany($company);
            }
        }
        return "Done";
    }


    public function findCompany($company_id){
       // dd(0);
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
                return "Not a Company";
            }
        }
        return "Invalid id";
    }

}
