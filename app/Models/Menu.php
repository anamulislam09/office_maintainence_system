<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    public function submenu()
    {
        return $this->hasMany(Menu::class,'parent_id')->with('subchild');
    }
    public function subchild()
    {
        return $this->hasMany(Menu::class,'child_id');
    }
}
