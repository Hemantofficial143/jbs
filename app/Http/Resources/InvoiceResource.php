<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request),[
            'user' => User::find($this->user_id),
            'customer' => Customer::find($this->customer_id),
            'items' => $this->items,
            'total_amount' => collect($this->items)->sum('total')
        ]);
    }
}
