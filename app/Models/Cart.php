<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','device_id','quantity','product_id'];

    public function product(){
    	return $this->hasOne('App\Models\Products', 'product_id', 'id')->select('name_' . lang() , ' as name', 'price', 'discount', 'id', 'description_' . lang() . ' as desc', 'category_id');
	}
}
