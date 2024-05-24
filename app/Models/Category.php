<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Category extends Model
{
    use HasFactory;
    // use Translatable;
    // public $translatedAttributes = ['title', 'meta_title','meta_description'];
    protected $fillable = 
    [
        'name',
        'status',
        'main_cat_id'
    ];
    
    // public function products()
    // {
    //     return $this->hasMany('App\Models\Product', 'cat_id')->where('status','=',1);
    // }
    public function subcategoris()
    {
        return $this->hasMany(Category::class,'main_cat_id')->where('status','=',1);
    }
}
