<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;



class EmployeeController extends Controller
{
    use Helpers;

    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index($company_id)
    {
        return $this->employeeRepository->getAllEmployees($company_id);
    }

    public function store(Request $request, $company_id)
    {
        $data = $request->input('data');
        $employee = $this->employeeRepository->addNewEmployee($company_id, $data);
        $response = [
            'employee' => $employee,
        ];

        return $response;
    }

    public function show($company_id, $employee_id)
    {
        return $this->employeeRepository->getEmployeeDetail($employee_id, $company_id);
    }

    public function update(Request $request, $company_id, $employee_id)
    {
        $data = $request->input('data');
        $employee = $this->employeeRepository->updateEmployeeDetail($employee_id, $company_id, $data);

        return $employee;
    }

    public function destroy($company_id, $employee_id)
    {
        return $this->employeeRepository->removeEmployee($company_id, $employee_id);
    }

    public function skills($company_id, $employee_id)
    {
        return $this->employeeRepository->getEmployeeSkills($employee_id);
    }

    public function educations($company_id, $employee_id)
    {
        return $this->employeeRepository->getEmployeeEducations($employee_id);
    }

    public function experiences($company_id, $employee_id)
    {
        return $this->employeeRepository->getEmployeeExperiences( $employee_id);
    }


    public function getData($userId)
    {
        return $this->employeeRepository->getData($userId);
    }

    public function getCompanyData($userId)
    {
        return $this->employeeRepository->getCompanyData($userId);
    }
}
