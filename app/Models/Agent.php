<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';
    protected $fillable = [
        'name', 'email', 'phone', 'username', 'password', 
        'branch_name', 'city', 'from_city', 'to_city', 
        'is_active', 'agent_code', 'address', 'image'
    ];
}
