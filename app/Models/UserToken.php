<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = ['user_id','complaint_id','order_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
