<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Parameter extends Model
{
    use SoftDeletes,Sluggable;
    use HasFactory; 


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function branches()
    {
        return $this->hasMany(ParameterBranch::class, 'parameter_id', 'id');
    }
    
}
