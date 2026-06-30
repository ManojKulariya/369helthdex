<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Payment extends Model
{
    use HasApiTokens, HasFactory;
    
    protected $fillable = [
        'lab_id',
        'order_id',
        'sample_boy_id',
        'price',
        'paymant_mode'
    ];
    
    public function user(){
        return $this->hasone("App\Models\User",'id','user_id');
     }
     
     public function order(){
        return $this->hasone("App\Models\Orders",'id','order_id');
     }
}
