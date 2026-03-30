<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = 'admin';
    protected $fillable = ['name', 'email', 'password', 'image'];
}
