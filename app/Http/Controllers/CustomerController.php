<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function get(Request $request){
        $authUser = $request->user();
        $data = Customer::where('user_id',$authUser->id)->get();
        return Response::success(CustomerResource::collection($data),'Data Fetched');
    }

    public function store(Request $request){

        $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'mobile' => ['required'],
        ]);

        $authUser = $request->user();

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->user_id = $authUser->id;
        $customer->save();
        return Response::success(new CustomerResource($customer),"Customer details saved!.");
    }

    public function update(Request $request,String $id){

        $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'mobile' => ['required'],
        ]);

        $authUser = $request->user();

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->save();
        return Response::success(new CustomerResource($customer),"Customer details Updated!.");

    }

    public function delete(String $id){
        Customer::find($id)->delete();
        return Response::success([],'Customer deleted!.');
    }

}
