<?php

namespace App\Repositories;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Employee;

use Illuminate\Support\Facades\DB;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployee($request)
    {
        $employees = new Employee();
        $employees->employee_name = $request->employee_name;
        $employees->email = $request->email;
        $employees->dob = $request->dob;
        // $employees->password = Hash::make($request->password);
        $employees->password =$request->password;
        $employees->gender = $request->gender;
        
        try{
        $employees->save();
        return true;
        }catch(Exception $e){
            return false;
        }

    }
    public function updateEmployee($request)
    {
        $employeeId=$request->id;
        DB::table('employees')
            ->leftjoin('emp_dep_positions','employees.id','=','emp_dep_positions.employee_id')
            ->where('employee_id',$employeeId)
            ->update([
                'employee_name' => $request->employee_name,
                'email' => $request->email,
                'dob' => $request->dob,
                'password' =>$request->password,
                'gender' => $request->gender,
                

                ]);
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
}
