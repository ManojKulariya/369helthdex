<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class UserAddress extends Model
{
    use HasFactory;
     use SoftDeletes;
    protected $table = 'user_addresses';

     public function citydata(){
        return $this->hasone("App\Models\City",'id','city');
     }
     
    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }
}
