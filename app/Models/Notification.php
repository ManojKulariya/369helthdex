<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Model
{
    use HasApiTokens, HasFactory;
    
    protected $fillable = [
        'order_id',
        'user_id',
        'message',
        'app'
    ];
    
    public function user(){
        return $this->hasone("App\Models\User",'id','user_id');
     }
}
