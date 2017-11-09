<?php

namespace mecadoapp\model;

class Liste extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'liste'; 
    protected $primaryKey = 'id';   
    public    $timestamps = false; 

    public function messages(){
<<<<<<< HEAD
    	return $this->hasMany(Message::class,'id_list');
=======
    	return $this->hasMany(Message::class,'id_liste');
>>>>>>> b395364f48fdb01cad7a4d2abd5e2fa70384635e
    }

    public function user(){
    	return $this->belongsTo(User::class,"id");
    }

    public function items(){
    	return $this->hasMany(Item::class,'id_liste');
    }
       
}