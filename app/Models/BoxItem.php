<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    protected $fillable = ['box_id','product_id','quantity'];

    public function box()
    {
        return $this->belongsTo('App\Models\Box', 'box_id', 'id');
    }

}
