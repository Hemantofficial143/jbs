<?php

namespace App\Http\Controllers;

use App\Http\Controllers\base\BaseEstimateController;
use App\Infrastructure\ApiResponse;
use App\Models\Estimate;
use Illuminate\Http\Request;

class EstimateController extends BaseEstimateController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimateData = Estimate::where('user_id',$this->getAuthUserID())->get()->toArray();
        return view('pages.estimate_list',['data' =>  $estimateData]);
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
        $response = new ApiResponse();
        $data = $request->all();
        $request->validate([
            "name" => "required",
            "mobile" => "required",
            "address" => "required"
        ]);
        
        if($data['id'] == "0"){
            $responseData = $this->storeEstimate($data,true);
            if($responseData['IsSuccess']){
                $response->IsSuccess = true;
                $response->SuccessMessage = "Estimate Addedd Successfully";
            } 
        }else{
            $responseData = $this->updateEstimate($data);
            if($responseData['IsSuccess']){
                $response->IsSuccess = true;
                $response->SuccessMessage = "Estimate Updated Successfully";
            }
        }
        return ($this->getJsonResponse($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function show(Estimate $estimate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estimate $estimate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    /*public function update($data)
    {
        $response = new ApiResponse();
        
        $request->validate([
            "id" => "required",
            "name" => "required",
            "mobile" => "required",
            "address" => "required"
        ]);
        
        return ($this->getJsonResponse($response));
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $response = new ApiResponse();
        $resData = $this->deleteEstimateData($request->id);
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->SuccessMessage= "Estimate Deleted Succesfully";
        }else{
            $response->ErrorMessage = @trans('common.some_went_wrong');
        }
        return $this->getJsonResponse($response);
    }



    public function get(){
        $response = new ApiResponse();
        $resData = $this->getEstimateData();
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $resData['data'];
        }else{
            $response->ErrorMessage = @trans('common.some_went_wrong');
        }
        return $this->getJsonResponse($response);
    }



    public function getOne(Request $request){
        $response = new ApiResponse();
        $id = decryptData($request->input('id'));
        $resData = $this->getOneEstimateData($id);
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $resData['data'];
        }else{
            $response->ErrorMessage = "Error While Fetching Data";
        }
        return $this->getJsonResponse($response);
        
        
    }





}
