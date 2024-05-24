<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequestDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_request_id',
        'product_id',
        'product_issue',
        'note'
    ];
}
