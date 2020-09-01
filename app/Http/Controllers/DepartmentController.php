<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Department;

    /**
     * Department.
     * Nay Htet
     * 25/8/2020
     * @return \Illuminate\Http\Response
     */
class DepartmentController extends Controller
{
    /**
     * Display a listing of the Department.
     * Nay Htet
     * 25/8/2020
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=Department::all();
        return $departments;
    }

    /**
     * Store a newly created  Department.
     * Nay Htet
     * 26/8/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  department_name 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   try{
            $data = $request->validate([
                'department_name' => 'bail|required|max:20',
                
            ]);
            $departments = new Department();
            $departments->department_name = $request->department_name;
            $departments->save();
            return response()->json([
                'status'=>'OK',
                'message' =>'Successful'],200); 
        }catch(QueryException $e){
            return response()->json([
                'message' =>$e->getMessage()
            ]);
        }
    }

    /**
     * Display Department.
     * Nay Htet
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departments=Department::where('id' ,'=' ,$id)->first();
        if($departments){
            return $departments;
        }else{
            return response()->json([
                'status'=>'NG',
                'message' =>'Not Found'],200);
        }
    }

    /**
     * Update the Department.
     * Nay Htet
     * 26/8/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  department_name,int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'department_name' => 'bail|required|max:20',
                
            ]);
            $departments = Department::find($id);
            if($departments){
                $departments->department_name = $request->department_name;
                $departments->save();
                return response()->json([
                    'Status'=>'NG',
                    'message' =>'Success'],200);
            }
            return response()->json([
                'message' =>'Data not found'],200);
        }catch(QueryException $e){
            return response()->json([
                'message' =>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * Nay Htet
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $departments=Department::where('id',$id)->first($id);
            if($departments){
                $departments=Department::where('id',$id)->first($id)->delete();
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
}
