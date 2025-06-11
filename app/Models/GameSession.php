<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class GameSession extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'puzzle_string', 'remaining_letters', 'is_active'];
    // Game sessions has many submissions by the student
    function submissions(){
        return $this->hasMany(Submission::class);
    }
    // The Game session is belongs to the student
    function student(){
        return $this->belongsTo(Student::class);
    }
}
