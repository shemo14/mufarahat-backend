<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['number','usage_number','expire_date','category_id','discount'];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories', 'category_id', 'id');
    }
}
