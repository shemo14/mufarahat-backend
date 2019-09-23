<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderComplaint extends Model
{
    protected $fillable = ['user_id','complaint_id','order_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function complaint()
    {
        return $this->belongsTo('App\Models\ComplaintReason', 'complaint_id', 'id');
    }



    


}
