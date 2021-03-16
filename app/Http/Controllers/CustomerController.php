<?php

namespace App\Http\Controllers;

use App\Http\Controllers\base\BaseCustomerController;
use App\Infrastructure\ApiResponse;
use App\Models\Customer;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class CustomerController extends BaseCustomerController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.customer_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        $respData = $this->storeUpdateCustomerData($reqData);
        if($respData['IsSuccess']){
            if($reqData['id'] == '0'){
                $response->IsSuccess = true;
                $response->SuccessMessage = "Customer Added Successfully";
            }else{
                $response->IsSuccess = true;
                $response->SuccessMessage = "Customer Details Updated Successfully";
            }
        }else{
            if($reqData['id'] == '0'){
                $response->IsSuccess = false;
                $response->ErrorMessage = "Something Went Wrong while add customer Please Try Again !!";
            }else{
                $response->IsSuccess = false;
                $response->ErrorMessage = "Something Went Wrong while update customer details Please Try Again !!";
            }
        }
        return $this->getJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = new ApiResponse();
        $respData = $this->deleteCustomer($request->id);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->SuccessMessage = "Customer Deleted Successfully";
        }else{
            $response->SuccessMessage = "Error while delete customer Try Again !!";
        }
        return $this->getJsonResponse($response);
    }

    public function get(){
        $response = new ApiResponse();
        $respData = $this->getAllCustomerData();
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $respData['Data'];
        }
        return $this->getJsonResponse($response);
    }

    public function getOne(Request $request){
        $response = new ApiResponse();
        $respData = $this->getOneCustomerData($request->id);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $respData['Data'];
        }
        return $this->getJsonResponse($response);
    }


}
