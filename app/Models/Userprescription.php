<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprescription extends Model
{
    use HasFactory;
    
    public function location()
    {
        return $this->belongsTo(City::class, 'location_id');
    }
}
