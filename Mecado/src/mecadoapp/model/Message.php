<?php

namespace mecadoapp\model;

class Message extends \Illuminate\Database\Eloquent\Model {

       protected $table      = 'message';
       protected $primaryKey = 'id';  
       public    $timestamps = true;  
       
}