<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Application extends Model
{
    use HasFactory;
    protected $table = 'applications';
    public function job()
    {
        return $this->belongsTo(Vacancie::class,'v_id');
    }
   
    
}
