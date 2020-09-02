<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\PositionRepositoryInterface;
use App\Http\Requests\PositionRregistrationValidationRequest;

class PositionRegistrationController extends Controller
{
    //

    public function __construct(PositionRepositoryInterface $positonRepo)
    {
        $this->positonRepo=$positonRepo;
    }
    
    public function save(PositionRregistrationValidationRequest $request)
    {
        $this->positonRepo->savePositon($request);
        
    }
}
