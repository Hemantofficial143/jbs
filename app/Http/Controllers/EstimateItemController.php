<?php

namespace App\Http\Controllers;

use App\Models\EstimateItem;
use Illuminate\Http\Request;
use App\Infrastructure\ApiResponse;
use App\Http\Controllers\base\BaseEstimateItemController;

class EstimateItemController extends BaseEstimateItemController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.estimate_items');
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
        //
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

}
