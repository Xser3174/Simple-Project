<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PositionRepositoryInterface;
use App\Position;

//use Your Model

/**
 * Class PositionRepository.
 */
class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function savePositon($request)
    {
        $positions = new Position();
        $positions->position_name = $request->position_name;
        $positions->position_rank = $request->position_rank;
        try{   
            $positions->save();
            return true;
        }catch(Exception $e)
        {
            return false;
        }
    }
}
