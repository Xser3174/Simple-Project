<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Employee;
use App\Emp_dep_position;

//Excel Imports & Exports Declaration
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
// use Excel;

//mail declaration** 
use Illuminate\Support\Facades\Mail;

//paginate assign
use Illuminate\Support\Facades\Config;

//validation
use App\Http\Requests\StoreMarket;

use Illuminate\Routing\Controller;


/**
     * Employee
     * Author
     * 25/8/2020
     *
     * 
     */
    
class EmployeeController extends Controller
{
    /**
     * Display a listing of the employee with positon id and departments id.
     * Author
     * 26/8/2020
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $perPage=Config::get('constant.per_page');
        $employees=Employee::with('department','position')->withTrashed()->paginate($perPage);
        return ['employees'=>$employees];
        
    }

    /**
     * Store a newly created resource in storage.
     * 
     * 26/8/2020
     *
     * @param  \Illuminate\Http\Request  $request
     * @param employee_name,email,dob,password,gender,position_id,department_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            $data = $request->validate([
                'employee_name' => 'bail|required|max:20',
                'email' => 'bail|required|unique:employees,email',
                'dob' =>'bail|nullable|date:Y-M-D|before:18 years ago',
                'password' =>'required|min:8',
                'gender' =>'required|boolean',
                'position_id' =>'required',
                'department_id' =>'required',
                
            ]);

            $employees = new Employee();
            $employees->employee_name = $request->employee_name;
            $employees->email = $request->email;
            $employees->dob = $request->dob;
            $employees->password = Hash::make($request->password);
            $employees->gender = $request->gender;
            $employees->save();
            // after employee save ,get maximum employee id
            $lastemp_id = Employee::max('id');
            // Position id is exist
            if($request->position_id){
                $position_id=$request->position_id;

            }else{
                    $position_id=Config::get('constants.position_id');
                }
                // Department id is exist
                if($request->department_id){
                    $department_id=$request->department_id;

                }else{
                        $department_id=Config::get('constants.department_id'); 
                    }
                    
                    
            
            $emp_dep_positions =new Emp_dep_position();
            $emp_dep_positions->employee_id =$lastemp_id;
            $emp_dep_positions->department_id =$department_id;
            $emp_dep_positions->position_id =$position_id;
            $emp_dep_positions->save();

            

            // return response()->json([
            //     'status'=>'OK',
            //     'message' =>'Successful'],200);
            
        }catch(QueryException $e){
            return response()->json([
                'message' =>$e->getMessage()
            ]);
        }

        //mail sent***
        Mail::raw('Your Registration is finish.',function($message){
            $message->subject('Registration')->from('lonlon.blah@gmail.com')->to('freedom.xser@gmail.com');
         });

    }

    /**
     * Display the Employee List.
     * Nay Htet
     * 27/8/2020
     *
     * @param  int  $id for employee 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employees=Employee::with('position','department')->where('id' ,'=' ,$id)->first();
        if($employees){
            return [
                'employees'=>$employees
            ];

            }else{
                return response()->json([
                    'status'=>'NG',
                    'message' =>'Not Found'],200);
        }
    }

    /**
     * Update the Employee.
     * Nay Htet
     * 26/8/2020
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param employee_name,email,dob,password,gender,position_id,department_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try{

            $data = $request->validate([
                'employee_name' => 'bail|required|max:20',
                'email' => 'bail|required|unique:employees,id',
                'dob' =>'required',
                'password' =>'required',
                'gender' =>'required',
                
            ]);
            //get all data from request ***
            //$employee=$request->all();

            $employees = Employee::find($id);
            $employees->employee_name = $request->employee_name;
            $employees->email = $request->email;
            $employees->dob = $request->dob;
            $employees->password = Hash::make($request->password);
            $employees->gender = $request->gender;
            $employees->update();
            
            $emp=Emp_dep_position::where('employee_id',$id)->first();
            if($emp){
                if($request->position_id){
                    $position_id=$request->position_id;
                }else{
                    $position_id=Config::get('constant.position_id');
                    }
                    if($request->department_id){
                        $department_id=$request->department_id;
                    }else{
                        $department_id=$request->department_id;;   
                        }

                $emp->department_id =$department_id;
                $emp->position_id =$position_id;
                $emp->update();

                return response()->json([
                    'status'=>'Ok',
                    'message' =>'Successful'],200);
            }else{
                return response()->json([
                    'message' =>'Data not found'],200);
            }  
        }catch(QueryException $e){
            return response()->json([
                'message' =>$e->getMessage()
            ]);
        }
    }

    /**
     * Soft-Delete from Employee and Emp_dep_position tables
     * Nay Htet
     * 27/8/2020
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $employees=Employee::where('id', $id)->first();
            if($employees){
                $employees=Employee::where('id', $id)->first()->delete();
                $emp_dep_position=Emp_dep_position::where('employee_id',$id)->first();
                if($emp_dep_position){
                    $emp_dep_position=Emp_dep_position::where('employee_id',$id)->first()->delete();   
                }
            return response()->json([
                'status'=>'Ok',
                'message' =>'Success'],200);
            }else{
                return response()->json([
                    'status'=>'NG',
                    'message' =>'Data not found'],200);
            }
        }catch(Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
                
            ]);
        }
        
    }

    /**
     * Force-Delete from Employee and Emp_dep_position tables
     * Nay Htet
     * 27/8/2020
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        //

        try{
            $employees = Employee::withTrashed()->where('id', $id)->first();
            if($employees){
                $employees = Employee::withTrashed()->where('id', $id)->forceDelete();
            }else{
                return response()->json([
                    'message' =>'Employee Id not found'],200);
            }
            $emp_dep_position = Emp_dep_position::withTrashed()->where('employee_id', $id)->first();
            if($emp_dep_position){
            $emp_dep_position = Emp_dep_position::withTrashed()->where('employee_id', $id)->forceDelete();
            
            }else{
                return response()->json([
                    'message' =>'Employee Id not found in emp_dep_position'],200);
            }
            return response()->json([
            'message' =>'Successful'],200);
        
        }catch(Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
                
            ]);
        }
       
    }

    /**
     * Seacrch Employee with Departments and Positions Tables
     * Nay Htet
     * 27/8/2020
     * @param  \Illuminate\Http\Request  $request-> id, employee_name
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request){

        $search_data=[];
        if($request->id){
            $search_id=['id',$request->id];
            array_push($search_data,$search_id);

        }if($request->name){
                $search_name=['employee_name','LIKE','%'.$request->name.'%'];
                array_push($search_data,$search_name);
            }
        $limit=(int)env('limit');
        $employees=Employee::with(['department','position'])
                            ->withTrashed()
                            ->where($search_data)
                            ->paginate($limit);
        return response()->json($employees,200);  
    }
    /**
     * Excel File Export 
     * 28/8/2020
     * @param  \Illuminate\Http\Request  $request-> id, employee_name
     * @return \Illuminate\Http\Response
     */
    public function fileExport(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        $search_data=[];
        if($request->id){
            $search_id=['id',$request->id];
            array_push($search_data,$search_id);

        }
        if($request->employee_name){
            $search_name=['employee_name',$request->employee_name];
            array_push($search_data,$search_name);

        }
        return Excel::download(new EmployeesExport($search_data), 'MttRegistrations.xlsx');
        
    }

    public function excel(Request $request)
	{
        
        // $excel = App::make('excel');
        $search_data=[];
        if($request->id){
            $search_id=['id',$request->id];
            array_push($search_data,$search_id);

        }if($request->name){

                $search_name=['employee_name','LIKE',$request->name.'%'];
                array_push($search_data,$search_name);

            }

        $limit=(int)env('limit');
        $employees=Employee::with(['department','position'])
                            ->withTrashed()
                            ->where($search_data)
                            ->first();
        // dd($employees);
		// $formal_data = Employee::table('formal')->get()->toArray();
		$programma_array[] = array('employee_name', 'email', 'dob', 'password', 'Gender');
			// dd($employees);
		// foreach($employees as $pass)
		// {
            
			$programma_array[] = array
			(
			'employee_name'=> $employees['employee_name'],
			'email'=> $employees['email'],
            'dob'=> $employees['dob'],
            'password'=> $employees['password'],
			'Gender'=> $employees['gender']
      		);
			
		//}
		
			
			Excel :: create('Programma_Data', function($excel) use ($programma_array)
			{
				// $excel->setTitle('Apotelesmata');
				// $excel->sheet('Programma_Data', function($sheet) use ($programma_array)
				// {
					$sheet->fromArray($programma_array, null, 'A1', false, false);
				// });
			})->download('xlsx');
			
	        
    }
			   
}

 