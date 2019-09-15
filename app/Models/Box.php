<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['name_ar','name_en','price','image'];

    public function items()
    {
        return $this->hasMany('App\Models\BoxItem', 'box_id', 'id');
    }
}
