<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Logics\EmployeeRepositoryLogic;
use App\Http\Requests\EmployeeUpdatingValidationRequest;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Http\Requests\EmployeeRregistrationValidationRequest;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;

class EmployeeRegistrationController extends Controller
{
    //

    public function __construct(EmployeeRepositoryInterface $employeeRepo,EmployeeRepositoryLogic $employeelogic)
    {
        $this->employeeRepo=$employeeRepo;
        $this->employeelogic=$employeelogic;
    }
    
    public function save(EmployeeRregistrationValidationRequest $request)
    {
        $this->employeeRepo->saveEmployee($request);
        $this->employeelogic->savePrepareData($request);
    }

    public function update(EmployeeUpdatingValidationRequest $request)
    {
        $employee=$this->employeeRepo->checkEmployee($request);
        if($employee->isEmpty())
        {
            return reponse()->json(['message'=>"Data is not Found"],200);
        }else{
            $this->employeeRepo->updateEmployee($request);
            $this->employeelogic->updatePrepaupreData($request);
        }

    }

}
