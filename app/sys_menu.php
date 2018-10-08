<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sys_menu extends Model
{
    // protected $primaryKey = ['node_group','node_menu'];
    protected $primaryKey = 'node_group';
    protected $table = 'sys_menus';

    public function group()
    {
        return $this->belongsTo('App\sys_group');
    }

}
