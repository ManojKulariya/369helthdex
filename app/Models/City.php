<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class City extends Model
{
    use HasFactory,Sluggable;
    protected $table = 'city';
    public function users()
    {
        return $this->hasMany(User::class,'city');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'city'
            ]
        ];
    }
    
    
}
