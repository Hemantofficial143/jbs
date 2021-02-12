<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use Illuminate\Http\Request;

class BaseEstimateController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response['IsSuccess'] = false;
    }

    public function storeEstimate($data,$returnData = false){
        $insert = Estimate::create([
            'user_id' => $this->getAuthUserID(),
            'customer_name' => $data['name'],
            'customer_mobile' => $data['mobile'],
            'customer_address' => $data['address']
        ]);
        if($insert){
            $this->response['IsSuccess'] = true;
            if($returnData == true){
                $this->response['data'] = $insert;
            }
        }
        return $this->response;
    }
}
