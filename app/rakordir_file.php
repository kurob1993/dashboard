<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rakordir_file extends Model
{
    use \Awobaz\Compoships\Compoships;
    public $timestamps = false;
    protected $table = 'rakordir_file';
    
    public function rakordir()
    {
        return $this->belongsTo('App\rakordir',['date','agenda_no'],['date','agenda_no']);
    }
}
