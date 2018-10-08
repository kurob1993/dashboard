<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sys_group extends Model
{
	protected $primaryKey = 'node_group';
	public $newAttribute = 'new attribute';

    public function menu()
    {
        return $this->hasMany('App\sys_menu','node_group','node_group');
    }
}
