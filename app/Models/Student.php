<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Authenticatable
{
    use HasFactory;
     protected $fillable = ['name', 'email'];

    // A student has many game sessions
    function gameSessions(){
       return $this->hasMany(GameSession::class);
    }
}
