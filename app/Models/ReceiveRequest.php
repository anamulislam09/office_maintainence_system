<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_from_office_id',
        'request_to_office_id',
        'created_by_id',
        'updated_by_id',
        'date',
        'note',
        'status'
    ];
}
