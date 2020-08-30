<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emp_dep_position extends Model
{
    //
    use SoftDeletes;
    public function employee(){
        return $this->belongsTo('App\Employee');
    }
    public function position(){
        return $this->belongsTo('App\Position');
    }

}
