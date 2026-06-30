<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homevisit extends Model
{
    use HasFactory;
     public function citydata(){
        return $this->hasone("App\Models\City",'id','lab_id');
     }
     public function lab(){
        return $this->hasone("App\Models\User",'id','lab_id');
     }
}
