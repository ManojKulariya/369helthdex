<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartMember extends Model
{
    use HasFactory;
    protected $table = 'cart_member';

    public function family_member_data(){
         return $this->hasone('App\Models\FamilyMember', 'id', 'family_member_id');
    }

}
