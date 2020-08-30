<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{

	use SoftDeletes;
    //
    public function department(){
        return $this->belongsToMany('App\Department','Emp_dep_positions','employee_id','department_id');
        
    }

    public function position(){
        return $this->belongsToMany('App\Position','Emp_dep_positions','employee_id','position_id');
        
    }
}
