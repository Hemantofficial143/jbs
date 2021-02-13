<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getJsonResponse($data){
            return response()->json($data);
    }

    public function getAuthUserDetails($guard = null){
        if($guard != null){
            return Auth::guard($guard)->user();
        }
        return Auth::user();
    }
    public function getAuthUserID($guard = null){
        return $this->getAuthUserDetails($guard)->id;
    }

}
