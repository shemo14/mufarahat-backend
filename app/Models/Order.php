<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','coupon_id','packaging_id','price','city_id','notes','lat','long','payment_type','status','name','dalegate_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function dalegate()
    {
        return $this->belongsTo('App\User', 'dalegate_id', 'id');
    }

    public function packaging()
    {
        return $this->belongsTo('App\Models\Packaging', 'packaging_id', 'id')->select('name_' . lang() . ' as name', 'id', 'price');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon', 'coupon_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }

    public function Answers()
    {
        return $this->hasMany('App\Models\QuestionUser', 'order_id', 'id');
    }

    public function Percentage()
    {
        return $this->belongsTo('App\Models\PercentageUser', 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    

}
