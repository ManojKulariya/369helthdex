<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    protected $table = 'transports';
    public function users()
    {
        return $this->hasone(User::class,'id','lab_id');
    }
    public function sendfrom()
    {
        return $this->hasone(User::class,'id','user_id');
    }
   
}
