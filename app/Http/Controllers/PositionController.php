<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Position;


    /**
     * Positon.
     * Nay Htet
     * 25/8/2020
     * @return \Illuminate\Http\Response
     */
class PositionController extends Controller
{
    /**
     * Display a listing of the positon.
     * Nay Htet
     * 25/8/2020
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions=Position::all();
        return $positions;
    }

    /**
     * Store a newly created store in Position.
     * Nay Htet
     * 26/8/2020
     * @param  \Illuminate\Http\Request  $request
     * @param  position_name,position_rank
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $request->validate([
                'position_name' => 'bail|required|max:20',
                'position_rank' =>'required',
                
            ]);
            $positions = new Position();
            $positions->position_name = $request->position_name;
            $positions->position_rank = $request->position_rank;
            $positions->save();
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
     * Display the Position List.
     * Nay Htet
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $positions=Position::where('id' ,'=' ,$id)->first();
        if($positions){
            return $positions;
        }else{
            return response()->json([
                'status'=>'NG',
                'message' =>'Not Found'],200);
        }
    }

    /**
     * Update the Positon.
     * Nay Htet
     * 26/8/2020
     * @param  \Illuminate\Http\Request  - Positions Name and Positions Rank
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->validate([
                'position_name' => 'bail|required|max:20',
                'position_rank' =>'required',
                
            ]);
            $positions = Position::find($id);
            if($positions){
                $positions->position_name = $request->position_name;
                $positions->position_rank = $request->position_rank;
                $positions->update();
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
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $positions=Position::where('id',$id)->first();
        if($positions){
            Position::where('id',$id)->first()->delete();
            return response()->json([
                'status'=>'Ok',
                'message' =>'Success'],200);
        }else{
            return response()->json([
                'status'=>'NG',
                'message' =>'Data not found'],200);
        }
    }
}
