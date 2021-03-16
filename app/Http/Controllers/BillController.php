<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use App\Infrastructure\ApiResponse;
use App\Http\Controllers\base\BaseBillController;
use Carbon\Carbon;
use Svg\Tag\Rect;

class BillController extends BaseBillController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customerData = [];
        $respData = $this->getCustomerData($id);
        if($respData['IsSuccess']){
            $customerData = $respData['Data'];
        }
        return view('pages.bill_list',['data' => $customerData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqData = $request->all();
        $response = new ApiResponse();
        $respData = $this->createBill($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->SuccessMessage = "Bill Created Successfully";
        }else{
            $response->ErrorMessage = "Something went Wrong !!";
        }
        return $this->getJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $reqData = $request->all();
        $response = new ApiResponse();
        $respData = $this->updateCustomerBill($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->SuccessMessage = "Bill Updated successfully !!";
        }else{
            $response->ErrorMessage = "Something went Wrong !!";
        }
        return $this->getJsonResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $reqData = $request->all();
        $response = new ApiResponse();
        $respData = $this->deleteCustomerBill($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->SuccessMessage = "Bill deleted successfully !!";
        }else{
            $response->ErrorMessage = "Something went Wrong !!";
        }
        return $this->getJsonResponse($response);
    }


    public function get(Request $request){
        $reqData = $request->all();
        $response = new ApiResponse();
        $respData = $this->getCustomerBills($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            foreach($respData['Data'] as $key => $data){
                $respData['Data'][$key]['id'] = encryptData($respData['Data'][$key]['id']);
                $respData['Data'][$key]['created_at'] = Carbon::parse($respData['Data'][$key]['created_at'])->format('jS M Y H:i A');
            }
            $response->Data = $respData['Data'];
        }else{
            $response->ErrorMessage = "Something went Wrong !!";
        }
        return $this->getJsonResponse($response);
    }

    public function getOne(Request $request){
        $reqData = $request->all();
        $response = new ApiResponse();
        $respData = $this->getCustomerBillOne($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $respData['Data'];
        }else{
            $response->ErrorMessage = "Something went Wrong !!";
        }
        return $this->getJsonResponse($response);
    }


}
