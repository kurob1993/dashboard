<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rakordir extends Model
{
    use \Awobaz\Compoships\Compoships;
    public $timestamps = false;
    protected $table = 'rakordir';
    protected $appends = ['datetime'];

    public function rakordirFiles()
    {
        return $this->hasMany('App\rakordir_file',['date','agenda_no'],['date','agenda_no']);
    }
    public function getDateTimeAttribute()
    {
        $date = date('d-m-Y',strtotime($this->date));
        return "{$date} <br> {$this->mulai} : {$this->keluar}";
    }
}
