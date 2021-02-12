<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_mobile',
        'customer_address',
        'user_id'
    ];
}
