<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'office_code',
        'head_office_id',
        'zonal_office_id',
        'title',
        'contact_no',
        'email',
        'location',
        'status'
    ];
}
