<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageBranch extends Model
{
    protected $table = 'package_branch'; // pivot table
    public $timestamps = false;
     protected $fillable = [
        'package_id',
        'branch_id','mrp','price'
    ];
    public function Package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
