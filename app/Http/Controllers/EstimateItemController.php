<?php

namespace App\Http\Controllers;

use App\Models\EstimateItem;
use Illuminate\Http\Request;
use App\Infrastructure\ApiResponse;
use App\Http\Controllers\base\BaseEstimateItemController;
use App\Models\Maap;
use Barryvdh\DomPDF\Facade as PDF;
class EstimateItemController extends BaseEstimateItemController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maap = Maap::all()->toArray();
        return view('pages.estimate_items',['maap' => $maap]);
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
        if($data['id'] == "0"){
            $responseData = $this->storeEstimateItem($data,true);
            if($responseData['IsSuccess']){
                $response->IsSuccess = true;
                $response->SuccessMessage = "Estimate Item Addedd Successfully";
            } 
        }else{
            $responseData = $this->updateEstimateItem($data);
            if($responseData['IsSuccess']){
                $response->IsSuccess = true;
                $response->SuccessMessage = "Estimate Item Updated Successfully";
            }
        }
        return $this->getJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstimateItem  $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function show(EstimateItem $estimateItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstimateItem  $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function edit(EstimateItem $estimateItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EstimateItem  $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstimateItem $estimateItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EstimateItem  $estimateItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstimateItem $estimateItem)
    {
        //
    }

    public function getAllEstimateItemData(Request $request){
        $response = new ApiResponse();
        $reqData = $request->all();
        $respData = $this->getEstimateItemsData($reqData);
        if($respData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $respData['data'];
        }else{
            $response->ErrorMessage = "Error While Fetching Data";
        }
        return $this->getJsonResponse($response);
    }

    public function getOne(Request $request){
        $response = new ApiResponse();
        $id = $request->input('id');
        $resData = $this->getOneEstimateItemData($id);
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $resData['data'];
        }else{
            $response->ErrorMessage = "Error While Fetching Data";
        }
        return $this->getJsonResponse($response);
    }


    public function exportPdf($id){
        $estimateData = $this->getEstimateItemsData(['id' => $id]);
        $estimates = [];
        foreach($estimateData['data'] as $items){
            if(!isset($estimates['customer_name'])){
                $estimates['customer_name'] = $items->customer_name;
            }
            if(!isset($estimates['customer_email'])){
                $estimates['customer_email'] = $items->customer_email;
            }

            if(!isset($estimates['customer_mobile'])){
                $estimates['customer_mobile'] = $items->customer_mobile;
            }
            if(!isset($estimates['customer_address'])){
                $estimates['customer_address'] = $items->customer_address;
            }
            if(!isset($estimates['created_at'])){
                $estimates['created_date'] = $items->created_at;
            }
            if(!isset($estimates['estimate_id'])){
                $estimates['estimate_id'] = $items->estimate_id;
            }
            unset($items->estimate_id);
            unset($items->customer_address);
            unset($items->customer_name);
            unset($items->customer_email);
            unset($items->customer_mobile);
            $estimates['data'][] = $items;
        }
        $pdf = PDF::loadView('templates.estimate',['estimate' => $estimates]);
        return $pdf->download($estimates['customer_name']."( ".$estimates['created_date']." ).pdf");
    }


}
