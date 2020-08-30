<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class EmployeesExport implements FromCollection, WithHeadings,WithTitle,ShouldAutoSize
{
    
    protected $search_data;
    public function __construct($search_data)
    {
        //
        $this->search_data = $search_data;
        
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return Employee::select('employee_name','email','password')->where($this->search_data)->get();
    }

    public function headings(): array
    {
    return ["Employee_name", "Email", "Password"];
    }

    public function title(): string
    {
    return 'Vouchers';
    }
}
