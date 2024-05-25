<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'sub_cat_id',
        'brand_id',
        'supplier_id',
        'office_id',
        'name',
        'product_code',
        'serial_no',
        'purchase_date',
        'purchase_price',
        'garranty',
        'garranty_end_date',
        'descriptions',
        'status',
        'location'
    ];
}
