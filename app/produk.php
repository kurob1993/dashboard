<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    public $timestamps = false;
    public function data()
    {
    	return $this->hasMany('App\data');
    }
}
