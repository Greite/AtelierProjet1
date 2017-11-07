<?php

namespace mecadoapp\model;

class Liste extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'liste'; 
    protected $primaryKey = 'id';   
    public    $timestamps = true; 

    public function messages(){
    	return $this->hasMany(Message::class,'id_List');
    }

    public function user(){
    	return $this->belongsTo(User::class,"id");
    }

    public function items(){
    	return $this->belongsToMany(Liste::class,'contenir','id','id_item');
    }
       
}