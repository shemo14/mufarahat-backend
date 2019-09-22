<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['dalegate_id','order_id','status'];

    public function dalegate()
    {
        return $this->belongsTo('App\User', 'dalegate_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
