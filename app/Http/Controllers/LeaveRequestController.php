<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LeaveRequestController extends Controller
{
    use Helpers;

    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    public function requestHistory($company_id, $employee_id)
    {
        return $this->employeeRepository->employeeLeaveRequestHistory($employee_id);
    }

    public function addRequest(Request $request, $company_id,$employee_id)
    {
        $input = $request->input('data');
        $leave_request = $this->employeeRepository->addEmployeeLeaveRequest($input, $employee_id);

        return $leave_request;
    }

    public function updateRequest(Request $request,$company_id, $employee_id, $request_id)
    {
        $input = $request->input('data');
        $leave_request = $this->employeeRepository->updateEmployeeLeaveRequest($input, $employee_id, $request_id);

        return $leave_request;
    }

    public function deleteRequest($company_id, $employee_id, $request_id)
    {
        return $this->employeeRepository->deleteEmployeeLeaveRequest($employee_id, $request_id);
    }

    public function allRequests($company_id)
    {
        return $this->employeeRepository->allRequests($company_id);
    }

    public function requestDetail($company_id, $employee_id, $request_id){
        $result = $this->employeeRepository->requestDetail($request_id);
        return $result;
    }
}
