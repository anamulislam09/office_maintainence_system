<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAllocate extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'office_id',
        'assign_date',
        'updated_date',
        'status',
        'location'
    ];
}
