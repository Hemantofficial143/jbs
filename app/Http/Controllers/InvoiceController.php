<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{


    public function show($invoice){
        return Response::success(new InvoiceResource(Invoice::find($invoice)),'Invoice Fetched');
    }


    public function get(Request $request){
        $authUser = $request->user();
        $invoices = Invoice::where('user_id',$authUser->id)->get();
        return Response::success(InvoiceResource::collection($invoices),'Invoice Fetched');
    }


    public function store(Request $request){

        $request->validate([
            'customer' => ['required'],
            'address' => ['required'],
        ]);


        $authUser = $request->user();
        $maxNumber = DB::table('invoices')->where('user_id',$authUser->id)->max('sequence');

        if($maxNumber == null){
            $seq = 1;
        }else{
            $seq = $maxNumber + 1;
        }
        $invoicePrefix = 'INV'.$seq;

        $invoice = new Invoice();
        $invoice->customer_id = $request->customer['id'];
        $invoice->user_id  = $authUser->id;
        if($request->has('date') && $request->date != null){
            $date = Carbon::parse($request->date)->toDateString();
        }else{
            $date = Carbon::now()->toDateString();
        }
        $invoice->invoice_date = $date;
        $invoice->address = $request->address;
        $invoice->invoice_number = $invoicePrefix;
        $invoice->sequence = $seq;
        $invoice->save();

        return Response::success([],"Invoice Created!.");
    }

    public function update(Request $request,$id){

        $request->validate([
            'customer' => ['required'],
            'address' => ['required'],
        ]);


        $authUser = $request->user();


        $invoice = Invoice::find($id);
        $invoice->customer_id = $request->customer['id'];
        if($request->has('date') && $request->date != null){
            $date = Carbon::parse($request->date)->toDateString();
        }else{
            $date = Carbon::now()->toDateString();
        }
        $invoice->invoice_date = $date;
        $invoice->address = $request->address;
        $invoice->save();

        return Response::success(new InvoiceResource($invoice),"Invoice Updated!.");
    }

}
