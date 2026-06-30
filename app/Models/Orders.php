<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

     public function orderdatas(){
        return $this->hasmany("App\Models\OrdersData",'order_id','id');
     }

     public function useraddressdetails(){
        return $this->hasone("App\Models\UserAddress",'id','sample_collection_address_id')->withTrashed();;
     }
     public function sampleboyDetails(){
        return $this->hasone("App\Models\User",'id','sample_collection_boy_id');
     }
     public function customer(){
        return $this->hasone("App\Models\User",'id','user_id');
     }
     public function franchise(){
        return $this->hasone("App\Models\User",'id','manager_id');
     }
      public function partiallyreports()
    {
        return $this->hasMany(Report::class, 'order_id', 'id');
    }
}
