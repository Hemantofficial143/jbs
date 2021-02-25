<?php

namespace App\Http\Controllers;

use App\Models\Maap;
use Illuminate\Http\Request;
use App\Infrastructure\ApiResponse;
use App\Http\Controllers\base\BaseMaapController;
use Exception;
use Svg\Tag\Rect;

class MaapController extends BaseMaapController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.setting.maap_list');
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
        $reqData = $request->all();
     
            if($reqData['id'] == "0"){
                $resData = $this->storeMaapData($reqData);
                if($resData['IsSuccess']){
                    $response->IsSuccess = true;
                    $response->SuccessMessage = "Maap Added Successfully";
                }else{
                    $response->ErrorMessage = $resData['ErrorMessage'];
                }
            }else{  
                $resData = $this->updateMaapData($reqData);
                if($resData['IsSuccess']){
                    $response->IsSuccess = true;
                    $response->SuccessMessage = "Maap Updated Successfully";
                }else{
                    $response->ErrorMessage = $resData['ErrorMessage'];
                }
            }
        return $this->getJsonResponse($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maap  $maap
     * @return \Illuminate\Http\Response
     */
    public function show(Maap $maap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maap  $maap
     * @return \Illuminate\Http\Response
     */
    public function edit(Maap $maap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maap  $maap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maap $maap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maap  $maap
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maap $maap)
    {
        //
    }

    public function getAllData(){
        $response = new ApiResponse();
        $resData = $this->getAllMaapData();
        //dd($resData);
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $resData['data'];
        }else{
            $response->ErrorMessage = "Error While Fetching Data";
        }
        return $this->getJsonResponse($response);
    }

    public function getOne(Request $request){
        $response = new ApiResponse();
        $resData = $this->getOneMaapData($request->input('id'));
        if($resData['IsSuccess']){
            $response->IsSuccess = true;
            $response->Data = $resData['data'];
        }else{
            $response->ErrorMessage = "Faild to Fetch Data";
        }
        return $this->getJsonResponse($response);
    }

}
