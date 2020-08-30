<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dep_has_position;

class Dep_has_positionControllerse extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Dep_has_position::all();
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
        $dep_has_position = new Dep_has_position();
        $dep_has_position->department_id = $request->department_id;
        $dep_has_position->position_id = $request->position_id;
        $dep_has_position->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $dep_has_position = Dep_has_position::withTrashed()->where('id', $id)->forceDelete();
    }
}
