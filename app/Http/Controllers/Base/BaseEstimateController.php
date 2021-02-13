<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use Exception;
use Illuminate\Http\Request;

class BaseEstimateController extends Controller
{
    public $response;
    public $estimateAlias = ['id as id','customer_name as name','customer_mobile as mobile','customer_address as address','customer_email as email'];
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

    public function getEstimateData($guard = null){
        $authID = $this->getAuthUserID($guard);
        $data = Estimate::where('user_id',$authID)->select($this->estimateAlias)->orderBy('id','DESC')->get()->toArray();
        foreach($data as $key => $d){
            $data[$key]['id'] = encryptData($data[$key]['id']);
        }
        $this->response['IsSuccess'] = true;
        $this->response['data'] = $data;
        return $this->response;
    }

    public function getOneEstimateData($id){    
        $this->response['IsSuccess'] = true;
        $this->response['data'] = Estimate::where('id',$id)->select($this->estimateAlias)->first()->toArray();
        return $this->response;
    }

    public function updateEstimate($data,$getData = false){
        $updatedData = Estimate::where('id',$data['id'])->update([
            'customer_name' => $data['name'],
            'customer_mobile' => $data['mobile'],
            'customer_address' => $data['address'],
            'customer_email' => $data['email'],
        ]);
        $this->response['IsSuccess'] = true;
        if($getData){
            $this->response['data'] = $updatedData;
        }
        return $this->response;
    }

}
