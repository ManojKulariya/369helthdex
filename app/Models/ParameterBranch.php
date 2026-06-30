<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterBranch extends Model
{
    protected $table = 'parameter_branch'; // pivot table
    public $timestamps = false;
     protected $fillable = [
        'parameter_id',
        'branch_id','mrp','price'
    ];
    public function Parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id', 'id');
    }
}
