<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    //
    protected $table ='attendance';
    protected $fillable = array('id','employee_id','status','activity_id');
    protected $primaryKey = 'id';

    public function kegiatan(){
        return $this->belongsTo('App\Models\Kegiatan','activity_id','id');
    }
    public function karyawan(){
        return $this->belongsTo('App\Models\Karyawan','employee_id','id');
    }
}
