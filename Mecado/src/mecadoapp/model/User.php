<?php

namespace mecadoapp\model;

class User extends \Illuminate\Database\Eloquent\Model {

   	protected $table      = 'user'; 
   	protected $primaryKey = 'id';    
   	public    $timestamps = false; 

   	public function liste(){
   		return $this->hasMany(Liste::class,"id");
   	} 


}