<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['name_ar','name_en','description_ar','description_en','price','discount','quantity','category_id'];


    public function category()
    {
        return $this->belongsTo('App\Models\Categories', 'category_id', 'id')->select('id' , 'name_' . lang() . ' as name');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'product_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite', 'product_id', 'id');
    }
}
