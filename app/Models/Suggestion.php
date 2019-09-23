<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['user_id','title','content','status','replay'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
