<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileBranch extends Model
{
    protected $table = 'profile_branch'; // pivot table
    public $timestamps = false;
     protected $fillable = [
        'profile_id',
        'branch_id','mrp','price'
    ];
    public function profile()
    {
        return $this->belongsTo(Profiles::class, 'profile_id', 'id');
    }
}
