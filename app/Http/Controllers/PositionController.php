<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Position;


    /**
     * Positon.
     * 
     * 25/8/2020
     * 
     * @return \Illuminate\Http\Response
     */
class PositionController extends Controller
{
    /**
     * Display a listing of the positon.
     * 
     * 25/8/2020
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $positions=Position::all();
        return $positions;
    }

    /**
     * Store a newly created store in Position.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $positions = new Position();
        $positions->position_name = $request->position_name;
        $positions->position_rank = $request->position_rank;
        $positions->save();
    }

    /**
     * Display the Position List.
     * 
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $positions=Position::where('id' ,'=' ,$id)->first();
        return $positions;
    }

    /**
     * Update the Positon.
     * 26/8/2020
     * @param  \Illuminate\Http\Request  - Positions Name and Positions Rank
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $positions = Position::find($id);

        $positions->position_name = $request->position_name;
        $positions->position_rank = $request->position_rank;

        $positions->update();
    }

    /**
     * Remove the specified resource from storage.
     * 27/8/2020
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Position::where('id',$id)->FirstOrFail()->delete();
    }
}
