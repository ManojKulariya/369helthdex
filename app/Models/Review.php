<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $casts = [
        'ratting' => 'string',
    ];
    public function userdata(){
        return $this->hasone("App\Models\User",'id','user_id');
    }
}
