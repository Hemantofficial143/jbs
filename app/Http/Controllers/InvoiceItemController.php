<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{

    public function store(Request $request,$invoice){
        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoice_id = $invoice;
        $invoiceItem->item_name = $request->item_name;
        $invoiceItem->item_description = $request->item_description;
        $invoiceItem->type = $request->type;
        $invoiceItem->height = $request->height;
        $invoiceItem->width = $request->width;
        $invoiceItem->rate = $request->rate;
        $invoiceItem->qty = $request->qty;
        $invoiceItem->total = $request->total;
        $invoiceItem->save();
        return Response::success($invoiceItem,'Item Added successfully.!');
    }

    public function delete(Request $request,$invoiceItem){
        InvoiceItem::find($invoiceItem)->delete();
        return Response::success([],'Item deleted successfully.!');
    }


}
