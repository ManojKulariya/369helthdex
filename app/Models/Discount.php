<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    
    public function Discountid(){
       return  $this->hasOne('App\Models\Discountid','dis_id' , 'id');
    }
    
}
