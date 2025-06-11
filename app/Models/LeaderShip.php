<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LeaderShip extends Model
{
    use HasFactory;
    protected $fillable = ['word', 'score', 'student_id'];
    public function student() { 
        return $this->belongsTo(Student::class); 
    }

}
