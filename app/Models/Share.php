<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $fillable = [
        'user_id',
        'blog_id', // or any other columns in your likes table
        'platform',
    ];
}
