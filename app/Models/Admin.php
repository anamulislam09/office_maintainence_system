<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;

class Admin extends Authenticate
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable =
    [
        'office_id',
        'name',
        'type',
        'mobile',
        'location_id',
        'email',
        'password',
        'image',
        'status',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'type');
    }
}
