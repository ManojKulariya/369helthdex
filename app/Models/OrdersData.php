<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersData extends Model
{
    use HasFactory;
    public function memberdetails(){
        return $this->hasone("App\Models\FamilyMember",'id','family_member_id');
     }
     
}
