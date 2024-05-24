<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'cat_id',
        'sub_cat_id',
        'name',
        'brand_id',
        'issue_date',
        'serial_no',
        'note',
        'status',
    ];
}
