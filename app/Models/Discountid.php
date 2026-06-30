<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discountid extends Model
{
    use HasFactory;
     protected $table = 'discount_ids';
    
    public function package(){
       return  $this->hasOne('App\Models\Package','id' , 'test_id');
    }
    
    public function test(){
       return  $this->hasOne('App\Models\Profiles','id' , 'test_id');
    }
     public function parameter(){
       return  $this->hasOne('App\Models\Parameter','id' , 'test_id');
    }
}
