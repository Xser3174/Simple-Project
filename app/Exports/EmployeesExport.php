<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Artisan;


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
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        return Employee::select('employee_name','email','dob','password','gender')
                        ->where($this->search_data)
                        ->FirstOrFail();
    }
    public function headings(): array
    {
    return ["ID","Employee_name", "Email","DOB", "Password","Gender"];
    }
    public function title(): string
    {
    return 'Vouchers';
    }
}
