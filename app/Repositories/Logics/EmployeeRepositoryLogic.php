<?php

namespace App\Repositories\Logics;

use App\Employee;
use App\Emp_dep_position;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;

// use Illuminate\Support\Facades\Log;

class EmployeeRepositoryLogic
{
    public function __construct(EmployeeDepartmentPositionRepositoryInterface  $empDepRepo)
    {
        $this->empDepRepo=$empDepRepo;
    }

    public function savePrepareData($request)
    {
        // Log::Info('reach');
        
        if($request->position_id){
            $position_id=$request->position_id;

        }else{
                $position_id=1;
            }
            // Department id is exist
            if($request->department_id){
                $department_id=$request->department_id;

            }else{
                    $department_id=1; 
                }
                $employeeId = Employee::max('id');
        $this->empDepRepo->saveEmployeeDep($employeeId, $position_id, $department_id);
                
        
        
    }
    public function updatePrepaupreData($request)
    {
        // Log::Info('reach');
        // $getId=$request->id;
        // $emp=Emp_dep_position::where('employee_id',$getId)->first();
        // dd($emp->employee_id);
        if($request->position_id){
            $position_id=$request->position_id;

        }else{
                $position_id=1;
            }
            // Department id is exist
            if($request->department_id){
                $department_id=$request->department_id;

            }else{
                    $department_id=1; 
                }
        // $employeeId=$emp->employee_id; 
        $employeeId=$request->employee_id;

        $this->empDepRepo->updateEmployeeDep($employeeId, $position_id, $department_id);
                
        
        
    }

    public function checkEmployee($request)
    {
        $employeeId=$request->id;
        $findEmployee=DB::table('employees')
        ->leftjoin('emp_dep_positions','employees.id','=','emp_dep_positions.employee_id')
        ->where('employee_id',$employeeId)
        ->get();
        return $findEmployee;
    }

    // public function checkEmployee($request)
    // {
    //     $employees = Employee::find($request->id);
    // }
}