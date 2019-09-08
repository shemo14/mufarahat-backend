<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable =['name','phone','address','city_id'];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function delegates()
    {
        return $this->hasMany('App\Models\Delegate', 'warehouse_id', 'id');
    }

    
}
