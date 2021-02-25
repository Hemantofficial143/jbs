<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Maap;
use Illuminate\Http\Request;
use DB;
use Exception;

class BaseMaapController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response['IsSuccess'] = false;
    }


    public function storeMaapData($data,$getData = false){
        try{
            $addMaap = Maap::create([
                'name' => $data['name'],
                'code' => $data['code']
            ]);
            if($addMaap){
                $this->response['IsSuccess'] = true;
                if($getData === true){
                    $this->response['data'] = $addMaap;
                }
            }
        }catch(Exception $e){
            $this->response['ErrorMessage'] = "Code Must be Unique";
        }
        return $this->response;
    }


    public function updateMaapData($data){
        try{
            $id = decryptData($data['id']);
            $updateData = Maap::where('id',$id)->update(['name' => $data['name'],'code' => $data['code']]); 
            if($updateData){
                $this->response['IsSuccess'] = true;
            }
        }catch(Exception $e){
            $this->response['ErrorMessage'] = "Code Must be Unique";
        }
        return $this->response;
    }

    public function getAllMaapData(){
        $this->response['IsSuccess'] = true;
        $data = Maap::all()->toArray();
        foreach($data as $key => $val){
            $data[$key]['id'] = encryptData($data[$key]['id']);
        }
        $this->response['data'] = $data;
        return $this->response;
    }

    public function getOneMaapData($id){
        $id = decryptData($id);
        $maapData = Maap::where('id',$id)->first()->toArray();
        if($maapData !== null){
            $this->response['IsSuccess'] = true;
            $maapData['id'] = encryptData($maapData['id']);
            $this->response['data'] = $maapData;
        }
        return $this->response;
    }

}
