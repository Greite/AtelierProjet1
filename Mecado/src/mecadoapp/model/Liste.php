<?php

namespace mecadoapp\model;

class Liste extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'liste'; 
    protected $primaryKey = 'id';   
    public    $timestamps = false; 

    public function messages(){
    	return $this->hasMany(Message::class,'id_List');
    }

    public function user(){
    	return $this->belongsTo(User::class,"id");
    }

    public function items(){
    	return $this->hasMany(Item::class,'id_list');
    }
       
}