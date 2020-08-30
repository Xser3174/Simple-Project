<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Employee;
use App\Emp_dep_position;

use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;

//mail**
use Illuminate\Support\Facades\Mail;

//paginate assign
use Illuminate\Support\Facades\Config;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $employees=Employee::all();
        $perPage=Config::get('constant.per_page');

        $limit=(int)env('limit');
        // $employees=Employee::paginate($limit);
        $employees=Employee::with('department','position')->onlyTrashed()->paginate($perPage);

        

        $employees=Employee::with('department','position')->onlyTrashed()->get();
        return ['employees'=>$employees,];
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            
            $employees = new Employee();
            $employees->employee_name = $request->employee_name;
            $employees->email = $request->email;
            $employees->dob = $request->dob;
            $employees->password = Hash::make($request->password);
            $employees->gender = $request->gender;
            $employees->save();
            // 
            $lastemp_id = Employee::max('id');
            if($request->position_id){
                $position_id=$request->position_id;

            }else{
                    $position_id=1;
                }
                if($request->department_id){
                    $department_id=$request->department_id;

                }else{
                        $department_id=1;   
                    }
                    
                    
            
            $emp_dep_positions =new Emp_dep_position();
            $emp_dep_positions->employee_id =$lastemp_id;
            $emp_dep_positions->department_id =$department_id;
            $emp_dep_positions->position_id =$position_id;
            $emp_dep_positions->save();

            

            return response()->json([
                'message' =>'Successful'],200);
            
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employees=Employee::with('position','department')->where('id' ,'=' ,$id)->first();
        return [
            'employees'=>$employees
           
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try{

            $employees = Employee::find($id);

            $employees->employee_name = $request->employee_name;
            $employees->email = $request->email;
            $employees->dob = $request->dob;
            $employees->password = $request->password;
            $employees->gender = $request->gender;
            $employees->save();

            // $lastemp_id = Employee::max('id');
            $emp=Emp_dep_position::where('employee_id',$id)->first();
            if($emp){

                if($request->position_id){
                    $position_id=$request->position_id;

                }else{
                        $position_id=1;
                    }

                    if($request->department_id){
                        $department_id=$request->department_id;

                    }else{
                            $department_id=1;   
                        }

                       
                $emp->department_id =$department_id;
                $emp->position_id =$position_id;
                $emp->update();
            }

            return response()->json([
                'message' =>'Successful'],200);
            
        }catch(QueryException $e){
            return response()->json([
                'message' =>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employees=Employee::where('id', $id)->FirstOrFail()->delete();
        $emp_dep_position=Emp_dep_position::where('employee_id',$id)->FirstOrFail()->delete();
        
    }
    public function forceDelete($id)
    {
        //
    
        $employees = Employee::withTrashed()->where('id', $id)->forceDelete();
        $emp_dep_position = Emp_dep_position::withTrashed()->where('employee_id', $id)->forceDelete();
        return false;
       
    }

    public function search(Request $request){

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
                            ->paginate($limit);
        return response()->json($employees,200);

        
    }
    public function fileExport(Request $request)
    {
    
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
}
 