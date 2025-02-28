<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $fillable=[
        'role_id',
        'user_id'
    ];
    
}
