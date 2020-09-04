<?php

namespace App\Repositories;

use App\Emp_dep_position;
//use Your Model
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
/**
 * Class EmployeeDepartmentPositionRepository.
 */
class EmployeeDepartmentPositionRepository implements EmployeeDepartmentPositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function saveEmployeeDep($employeeId, $position_id, $department_id)
    {
        $emp_dep_positions =new Emp_dep_position();
        $emp_dep_positions->employee_id =$employeeId;
        $emp_dep_positions->department_id =$department_id;
        $emp_dep_positions->position_id =$position_id;
        $emp_dep_positions->save();
    }

    public function updateEmployeeDep($employeeId, $position_id, $department_id)
    {
        DB::table('employees')
        ->leftjoin('emp_dep_positions','employees.id','=','emp_dep_positions.employee_id')
        ->where('employee_id',$employeeId)
        ->update([
            'position_id' => $position_id,
            'department_id' => $department_id,
            ]);
    }
}
