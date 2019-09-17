<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PercentageUser extends Model
{
    protected $fillable = ['user_id','order_id','percentage'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

}
