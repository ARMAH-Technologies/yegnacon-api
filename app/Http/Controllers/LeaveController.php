<?php

namespace App\Http\Controllers;

use App\Repositories\LeaveRepository;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    use Helpers;

    protected $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository)
    {
        $this->leaveRepository = $leaveRepository;
    }

    //leave
    public function index()
    {
        $leaves = $this->leaveRepository->getAllLeaveTypes();
        return $leaves;
    }

    public function store(Request $request)
    {
        $input = $request->input('data');
        $leave = $this->leaveRepository->addNewLeaveType($input);

        return $leave;
    }

    public function update(Request $request, $leave_id)
    {
        $input = $request->input('data');
        $leave = $this->leaveRepository->updateLeaveType($input, $leave_id);

        return $leave;
    }

    public function destroy($leave_id)
    {
        $result = $this->leaveRepository->deleteLeaveType($leave_id);

        return $result;
    }

    //employee leave

    public function balance($company_id, $employee_id, $leave_id)
    {
        $balance = $this->leaveRepository->getLeaveBalance($employee_id, $leave_id);
        return $balance;
    }

    public function allBalance($company_id, $employee_id)
    {
        $balances = $this->leaveRepository->getAllLeaveBalance($company_id, $employee_id);
        return $balances;
    }

    //company leave

    public function getCompanyLeaves($company_id)
    {
        $leaves = $this->leaveRepository->getCompanyLeaveValues($company_id);
        return $leaves;
    }

    public function addCompanyLeave(Request $request, $company_id)
    {
        $input = $request->input('data');
        $leave = $this->leaveRepository->addCompanyLeave($input, $company_id);
        return $leave;
    }

    public function updateCompanyLeave(Request $request, $company_id)
    {
        $input = $request->input('data');
        $leave = $this->leaveRepository->updateCompanyLeave($input, $company_id);
        return $leave;
    }

    public function deleteCompanyLeave($company_id, $leave_id)
    {
        $result = $this->leaveRepository->deleteCompanyLeave($leave_id, $company_id);
        return $result;
    }
    public function giveDefault()
    {
        $result = $this->leaveRepository->giveDefaultLeaveToAll();
        return $result;
    }

}
