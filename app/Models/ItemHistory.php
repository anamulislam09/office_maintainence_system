<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'location_id',
        'issue_date',
        'created_by_id',
        'status',
        'note',
    ];
}
