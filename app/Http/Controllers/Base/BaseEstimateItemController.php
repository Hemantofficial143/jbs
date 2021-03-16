<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\EstimateItem;
use Illuminate\Http\Request;
use DB;

class BaseEstimateItemController extends Controller
{
    public $response;
    public function __construct()
    {
        $this->response['IsSuccess'] = false;
    }
    public function getEstimateItemsData($data){
        if(is_array($data)){
            if(isset($data['id']) && $data['id'] != ""){
                $id = decryptData($data['id']);
                $qry = DB::table('estimate_items')
                ->rightJoin('estimates','estimates.id','=','estimate_items.estimate_id')
                ->join('maaps','maaps.id','=','estimate_items.maap_id')
                ->where('estimates.id',$id)->where('estimates.user_id',$this->getAuthUserID())
                ->select('estimate_items.id as id','estimate_items.name as name','estimate_items.price as price','maaps.name as maap','estimate_items.description as description','estimates.customer_name','estimates.customer_mobile','estimates.customer_address','estimates.customer_email','estimates.created_at','estimates.id as estimate_id','estimates.note')->get()->toArray();
                foreach($qry as $q){
                    $q->id = encryptData($q->id);
                }
                $this->response['IsSuccess'] = true;
                $this->response['data'] = $qry;
            }
        }
        return $this->response;
    }

    public function storeEstimateItem($data,$returnData = false){
        $insert = EstimateItem::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => ($data['description'] != "")?$data['description']:NULL,
            'user_id' => $this->getAuthUserID(),
            'estimate_id' => decryptData($data['estimate_id']),
            'maap_id' => $data['maap'],
        ]);
        if($insert){
            $this->response['IsSuccess'] = true;
            if($returnData == true){
                $this->response['data'] = $insert;
            }
        }
        return $this->response;
    }

    public function updateEstimateItem($data,$returnData = false){
        $updatedData = EstimateItem::where('id',decryptData($data['id']))->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => ($data['description'] != "")?$data['description']:NULL,
            'maap_id' =>$data['maap']
        ]);
        $this->response['IsSuccess'] = true;
        if($returnData == true){
            $this->response['data'] = $updatedData;
        }
        return $this->response;
    }

    public function getOneEstimateItemData($id){
        $this->response['IsSuccess'] = true;
        $data = EstimateItem::where('id',decryptData($id))->first()->toArray();
        $data['id'] = encryptData($data['id']);
        $this->response['data'] = $data;
        return $this->response;
    }

}
