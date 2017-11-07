<?php

namespace mecadoapp\model;

class Item extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'item';  
    protected $primaryKey = 'id';     
    public    $timestamps = false;
       
    public function listes(){
    	return $this->belongsToMany(Liste::class,'contenir','id_item','id');
    }

}