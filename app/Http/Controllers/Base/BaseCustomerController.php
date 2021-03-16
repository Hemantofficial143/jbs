<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class BaseCustomerController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response['IsSuccess'] = false;
    }
    public function storeUpdateCustomerData($data){
        if($data['id'] == "0"){
            $insertCustomer = Customer::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'email' => isset($data['email'])?$data['email']:null,
                'address' => $data['address'],
                'user_id' => $this->getAuthUserID()
            ]);
            if($insertCustomer){
                $this->response['IsSuccess'] = true;
            }
        }else{
            $id = decryptData($data['id']);
            $updateCustomer = Customer::where('id',$id)->update([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'email' => isset($data['email'])?$data['email']:null,
                'address' => $data['address']
            ]);
            if($updateCustomer){
                $this->response['IsSuccess'] = true;
            }
        }
        return $this->response;
    }


    public function getAllCustomerData(){
        $customerData = Customer::where('user_id',$this->getAuthUserID())->get()->toArray();
        foreach($customerData as $key => $val){
            $customerData[$key]['id'] = encryptData($customerData[$key]['id']);
        }
        $this->response['IsSuccess'] = true;
        $this->response['Data'] = $customerData;
        return $this->response;
    }

    public function getOneCustomerData($id){
        $customerData = Customer::where('id',decryptData($id))->first()->toArray();
        $customerData['id'] = encryptData($customerData['id']);
        $this->response['IsSuccess'] = true;
        $this->response['Data'] = $customerData;
        return $this->response;
    }

    public function deleteCustomer($id){
        Customer::where('id',decryptData($id))->delete();
        $this->response['IsSuccess'] = true;
        return $this->response;
    }
}
