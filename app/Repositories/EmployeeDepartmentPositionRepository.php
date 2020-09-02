<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
//use Your Model
use App\Emp_dep_position;
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
        $emp=Emp_dep_position::where('employee_id',$employeeId)->first();
        $emp->department_id =$department_id;
        $emp->position_id =$position_id;
        $emp->update();
        
    }
}
