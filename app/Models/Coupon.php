<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    
    public function package(){
       return  $this->hasOne('App\Models\Package','id' , 'product_ids');
    }
    
    public function test(){
       return  $this->hasOne('App\Models\Profiles','id' , 'product_ids');
    }
     public function parameter(){
       return  $this->hasOne('App\Models\Parameter','id' , 'product_ids');
    }
}
