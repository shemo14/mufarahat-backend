<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable =['name_ar','name_en','shipping'];

    public function warehouses()
    {
        return $this->hasMany('App\Models\Warehouse', 'city_id', 'id');
    }
}
