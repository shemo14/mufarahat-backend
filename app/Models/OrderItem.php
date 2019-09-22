<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_id','quantity','price'];

    public function product(){
    	return $this->hasOne('App\Models\Product', 'id', 'product_id')->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'price', 'id', 'category_id' );
	}

    
}
