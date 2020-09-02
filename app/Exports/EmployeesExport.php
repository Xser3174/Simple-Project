<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;


/**
     * Export Excel
     * Nay Htet
     * 25/8/2020
     * @return \Illuminate\Http\Response
     */
class EmployeesExport implements FromCollection, WithHeadings,WithTitle,ShouldAutoSize
{
    
    protected $search_data;
    /**
     * Construct for create object.
     *  Nay Htet
     * 26/8/2020
     * @param  $search_data
     * @return $this->search_data
     */
    public function __construct($search_data)
    {
        //
        $this->search_data = $search_data;
        
    }
    /**
    * Get Query to export
    * 26/8/2020
    * Nay Htet
    * @return employee_name,email,password,gender
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $employee=$this->search_data;
    //  dd($key = array_search ('0', $this->search_data));
        
        print_r($employee);
        die();
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        // return Employee::select('id','employee_name','email','dob','password','gender')
        //                 ->where($this->search_data) 
        //                 ->get();
        return DB::table('employees')
        ->join('emp_dep_positions', 'employees.id', '=', 'emp_dep_positions.employee_id')
        ->join('positions', 'emp_dep_positions.position_id', '=', 'positions.id')
        ->join('departments', 'emp_dep_positions.department_id', '=', 'departments.id')
        ->where('employees.employee_name','=',$employee)
        ->select('employees.employee_name','employees.email','employees.dob', 'positions.position_name', 'departments.department_name')
        ->get();
    }
    public function headings(): array
    {
    return ["Employee_name", "Email","DOB", "Position Name","Department Name"];
    }
    public function title(): string
    {
    return 'Vouchers';
    }
}
