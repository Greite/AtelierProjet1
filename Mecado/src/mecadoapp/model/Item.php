<?php

namespace mecadoapp\model;

class Item extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'item';  
    protected $primaryKey = 'id';     
    public    $timestamps = false;
       
    public function liste(){
    	return $this->belongsTo(Liste::class,'id_list');
    }

}