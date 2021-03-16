<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;

class BaseBillController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response['IsSuccess'] = false;
    }


    public function getCustomerData($id){
        $data = Customer::where('id',decryptData($id))->first();
        if($data == null){
            $this->response['IsSuccess'] = false;    
        }else{
            $this->response['IsSuccess'] = true;
            $this->response['Data'] = $data->toArray();
        }
        return $this->response;
    }

    public function createBill($data,$guard = "web"){
        $createBill = Bill::create([
            'customer_id' => decryptData($data['customer_id']),
            'user_id' => $this->getAuthUserID($guard),
            'notes' => isset($data['notes'])?$data['notes']:null,
        ]);
        if($createBill){
            $this->response['IsSuccess'] = true;
        }
        return $this->response;
    }

    public function getCustomerBills($data,$guard = "web"){
        if(isset($data) && count($data) > 0){
            if(isset($data['customer_id'])){
                $billdata = Bill::where('customer_id',decryptData($data['customer_id']))->get()->toArray();
                $this->response['IsSuccess'] = true;
                $this->response['Data'] = $billdata;
            }
        }
        return $this->response;
    }

    public function getCustomerBillOne($data,$guard = "web"){
        if(isset($data) && count($data) > 0){
            if(isset($data['id'])){
                $bill = Bill::where('id',decryptData($data['id']))->first();
                if($bill != null){
                    $bill = $bill->toArray();
                    $bill['id'] = encryptData($bill['id']);
                    $this->response['IsSuccess'] = true;
                    $this->response['Data'] = $bill;

                }
            }
        }
        return $this->response;
    }

    public function deleteCustomerBill($data,$guard = "web"){
        if(isset($data) && count($data) > 0){
            if(isset($data['bill_id']) && isset($data['customer_id'])){
                $deleteBill = Bill::where([
                    'id' => decryptData($data['bill_id']),
                    'customer_id' => decryptData($data['customer_id']),
                    'user_id' => $this->getAuthUserID($guard)
                ])->delete();
                if($deleteBill){
                    $this->response['IsSuccess'] = true;
                }
            }
        }
        return $this->response;
    }

    public function updateCustomerBill($data,$guard = "web"){
        if(isset($data) && count($data) > 0){
            if(isset($data['id'])){
                $updatedBill = Bill::where([
                    'id' => decryptData($data['id'])
                ])->update([
                    'notes' => isset($data['notes'])?$data['notes']:null
                ]);
                if($updatedBill){
                    $this->response['IsSuccess'] = true;
                }
            }
        }
        return $this->response;
    }

}
