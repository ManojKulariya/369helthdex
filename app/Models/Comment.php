<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';   
    protected $fillable = [
        'user_id',
        'blog_id', // or any other columns in your likes table
        'comment',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
