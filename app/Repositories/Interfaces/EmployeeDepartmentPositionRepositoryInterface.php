<?php

namespace App\Repositories\Interfaces;

interface EmployeeDepartmentPositionRepositoryInterface 
{
    public function saveEmployeeDep($employeeId, $position_id, $department_id);
    public function updateEmployeeDep($employeeId, $position_id, $department_id);
}